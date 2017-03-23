var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var sanitizeHtml = require('sanitize-html');
var MongoClient = require('mongodb').MongoClient;
var ObjectID = require('mongodb').ObjectID;
var MongoDB = require('./helpers/MongoDB.js');

var Utils = require('./helpers/Utils.js');
var params = require('./config/params.js');

var jquery = fs.readFileSync("jquery-1.12.1.min.js", "utf-8");

try{
	var posts_prepare=params.posts_prepare;
    var posts=params.posts;
	var connString=params.db_conn_string;
	console.log("==>Begin get posts prepare to crawl");
    var Posts = {
        crawl: function(){
            //get posts_prepare to crawl
            MongoClient.connect(connString, function(err, db) {
                console.log(err);
                console.log("Connected correctly to server and start insert");
                var condition = {};
                condition.status=0;
                MongoDB.findDocuments(posts_prepare,db, condition,1,function(results) {
                    console.log('Count:'+results.length);
                    if(results.length>0){
                        //updated da crawl
                        var collection = db.collection(posts_prepare);
                        var id = results[0]._id;
                        var docs = results[0];
                        collection.updateOne({ _id : new ObjectID(id) }
                            , { $set: { status : 1 } }, function(err, result) {
                            //assert.equal(err, null);
                            //assert.equal(1, result.result.n);
                            console.log("Updated the document with the field a equal to 2");
                            //callback(result);
                            db.close();
                            console.log("==>Begin crawl post");
                            CrawlPostsDetail(docs);
                        });

                        /*for (var i = 0; i < results.length; i++) {
                            var docs = results[i];
                            var urlSite = docs.url_posts;
                            console.log(urlSite);
                            CrawlPostsDetail(docs);
                        }*/
                    }else{
                        console.log("Not found to crawl");
                    }
                    db.close();
                    console.log('Closed connect mongo');
                });
            });
        },
        updatePostsPrepareDone: function(posts_prepare_id, posts_id)
        {
            MongoClient.connect(connString, function(err, db) {
                var collection = db.collection(posts_prepare);
                collection.updateOne({ _id : new ObjectID(posts_prepare_id) }
                    , { $set: { status : 2, posts_id: posts_id} }, 
                    function(err, result) {
                        db.close();
                    });
            });
        }
    }
	
    function CrawlPostsDetail(docs){
    	var urlSite = docs.url_posts;
    	if(urlSite!='' && urlSite!=null){
    		 
    		jsdom.env({
                url: urlSite,
                src: [jquery],
                done: function (err, window) {
                    //if(window.hasOwnProperty('$')){
                        console.log('==>Begin Crawler on: '+urlSite);
                    //console.log(window);
                    //if ('$' in window) {
                    if(typeof window === 'object'){
					var $ = window.$;
					var data = [];
					var ObjDocument = {};
					var mainContent = $("#left_calculator");
                    mainContent.find(".box_quangcao").remove();
                    var allImgContent = [];
                    mainContent.find(".fck_detail img").each(function(index){
                        var src = $(this).attr("src");
                        $(this).attr("src",":img-"+index);
                        allImgContent.push(src);
                    })
                    ObjDocument.imgsrc = allImgContent;
                    ObjDocument.imgdest = "";
					ObjDocument.title = docs.title;
					ObjDocument.slug = docs.slug;
                    var intro = sanitizeHtml(docs.intro_text, {
                                        allowedTags: false,
                                        allowedAttributes: false
                                    });
					ObjDocument.intro_text = intro.trim();
                    var fullText = sanitizeHtml(mainContent.find(".fck_detail").html(), {
                                      allowedTags: [ 'b', 'i', 'em', 'strong', 'p','img' ],
                                      allowedAttributes: {
                                        'img': ['src']
                                      }
                                    });

                    fullText = fullText.replace(/(\r\n|\n|\r|\t)/gm,"");
                    ObjDocument.thumb = "";
					ObjDocument.full_text = fullText.trim();
                    ObjDocument.view=0;
                    ObjDocument.category=docs.category;
                    ObjDocument.created_time = new Date().toISOString();      
                    ObjDocument.status=0;
                    /*allImgContent.forEach(function(entry) {
                        var fileName = Utils.getFileType(entry);
                        var pathFile = params.storage+params.DS+entry;
                        //console.log(entry);
                    });*/
                    /*for(var i=0; i<allImgContent.length; i++){
                        var fileType = Utils.getFileType(allImgContent[i]);
                        var pathStorage = Utils.getPathStorage();
                        if(!fs.existsSync(pathStorage)){
                        	mkdirp.sync(pathStorage);
                        }
                        var pathFile = pathStorage+params.DS+i+'.'+fileType;
                        console.log('download to:'+pathFile);
                        Utils.download(allImgContent[i], pathFile, function(res){
                            console.log('download callback:'+res);
                        });
                    }*/
                    //return;
                    //console.log("Images in body: "+allImgContent);
                    //console.log(ObjDocument);
                    console.log("==>Begin insert mongo");
                    var data = [];
                    data.push(ObjDocument);
                    MongoClient.connect(connString, function(err, db) {
                        console.log("Connected correctly to server and start insert");

                        MongoDB.insertDocuments(posts,db, data,function(res) {
                        	//console.log('res insert:'+JSON.stringify(res));
                        	//console.log(JSON.stringify(res));
                        	//return;
                            if(typeof res.ops[0] === 'object'){
                            	console.log(res.ops[0]._id);
                            	if(res.ops[0]._id!=''){
                            		findAndDownload(res.ops[0]._id);
                            	}
                                //update thumb
                                var posts_id = res.ops[0]._id;

                                var thumbUrl = docs.thumb;
                                var fileType = Utils.getFileType(thumbUrl);
                                var pathStorage = Utils.getPathStorage();
                                if(!fs.existsSync(pathStorage)){
                                    mkdirp.sync(pathStorage);
                                }

                                var pathFile = pathStorage+params.DS+res.ops[0]._id+'-thumb.'+fileType;
                                var pathUrl = pathFile.replace(params.storage,params.storage_url);
                                Utils.download(thumbUrl, pathFile, function(res){
                                    //update thumb
                                    var collection = db.collection(posts);
                                      // Update document where a is 2, set b equal to 1
                                    collection.updateOne({ _id : new ObjectID(posts_id) }
                                        , { $set: { thumb : pathUrl } }, function(err, result) {
                                        //assert.equal(err, null);
                                        //assert.equal(1, result.result.n);
                                        console.log("Updated the document with the field a equal to 2");
                                        db.close();
                                    });
                                    Posts.updatePostsPrepareDone(docs._id,posts_id);
                                });
                            }
                            //db.close();
                            console.log('Closed connect mongo');
                        });
                    });

                    function findAndDownload(id){
                    	//id = '56e197901af18540109f59a3';
                    	MongoClient.connect(connString, function(err, db) {
                    		var condition = {};
					        condition._id= new ObjectID(id);
					        //condition.status=1;
					        MongoDB.findDocuments(posts,db, condition,1,function(results) {
					        	console.log('find again:'+JSON.stringify(results));
					        	//download file and update full_text again
					        	var allImgContent = results[0].imgsrc;
					        	var imgFullText = [];
					        	for(var i=0; i<allImgContent.length; i++){
			                        var fileType = Utils.getFileType(allImgContent[i]);
			                        var pathStorage = Utils.getPathStorage();
			                        if(!fs.existsSync(pathStorage)){
			                        	mkdirp.sync(pathStorage);
			                        }
			                        var pathFile = pathStorage+params.DS+id+'-'+i+'.'+fileType;
                                    var pathUrl = pathFile.replace(params.storage,params.storage_url);
			                        imgFullText[':img-'+i] = pathUrl;
			                        console.log('download to:'+pathFile);
			                        /*if(fs.existsSync(pathFile)){
			                        	fs.unlinkSync(pathFile);
			                        }*/
			                        Utils.download(allImgContent[i], pathFile, function(res){
			                            console.log('download callback:'+res);
			                        });
			                    }
			                    updateFullText(id, imgFullText, results[0].full_text);
					        	db.close();
					            console.log('Closed connect mongo');
					        });
					    });
                    }
                    function updateFullText(id, imgArr, fullText){
                    	var keyS = [];
                        var imageDest = [];
                    	for (var key in imgArr){
						    console.log(key, imgArr[key]);
						    keyS.push(key);
						    fullText = fullText.replace(key, imgArr[key]);
                            imageDest.push(imgArr[key]);
						}
                    	//var str = "Mr Blue has a blue house and a blue car";
						
						MongoClient.connect(connString, function(err, db) {
                    		var collection = db.collection(posts);
						      // Update document where a is 2, set b equal to 1
						      collection.updateOne({ _id : new ObjectID(id) }
						        , { $set: { 
                                    full_text : fullText,
                                    imgdest: imageDest
                                    } }, function(err, result) {
						        //assert.equal(err, null);
						        //assert.equal(1, result.result.n);
						        console.log("Updated the document with the field a equal to 2");
						        //callback(result);
                                Posts.crawl();
						        db.close();
						      });  
                    	});
                    }
                    }
                }
            })
    	}else{
            var collection = db.collection('posts_prepare');
              // Insert some documents
              collection.deleteOne({ _id : new ObjectID(docs._id) }, function(err, result) {
                //assert.equal(err, null);
                //assert.equal(1, result.result.n);
                console.log("Removed the document with the field a equal to 3");
                Posts.crawl();
              });
            
            console.log("siteUrl Null: "+urlSite);
        }
    }
}catch(e)
{
	console.log('Exception: '+e);
}

Posts.crawl();