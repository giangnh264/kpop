var fs = require('fs');
var jsdom = require('jsdom');
var Utils = require('./helpers/Utils.js');
var MongoClient = require('mongodb').MongoClient;
var MongoDB = require('./helpers/MongoDB.js');
var params = require('./config/params.js');
var assert = require('assert');
var url = params.db_conn_string;
var jquery = fs.readFileSync("jquery-1.12.1.min.js", "utf-8");
var siteUrlSource ="http://suckhoe.vnexpress.net/tin-tuc/dinh-duong/page/1.html";
var page=1;
var Crawler = {
    /*checkExists: function(slug){

    },*/
    executed: function(urlSource){
        try{
            console.log('==>Begin Crawler.executed');
            console.log('====>site:'+urlSource);
            jsdom.env({
                url: urlSource,
                src: [jquery],
                done: function (err, window) {
                    if(typeof window === 'object'){
                    var $ = window.$;
                    var mainContent = $("#container");
                    var data = [];
                    console.log('==>Begin find content');
                    mainContent.find("#news_home li").each(function(){
                        var ObjDocument = {};
                        ObjDocument.title = $(this).find(".title_news a").text().trim();
                        ObjDocument.slug = Utils.slug(ObjDocument.title);
                        if(ObjDocument.slug!='' && ObjDocument.slug!=null){
                            ObjDocument.url_posts = $(this).find(".title_news a").attr("href");
                            ObjDocument.thumb = $(this).find(".thumb img").attr("src");
                            ObjDocument.intro_text = $(this).find(".news_lead").text();
                            ObjDocument.category = {
                                                        "_id":"56ec40f1037995100b00002a",
                                                        "name":"Du lịch",
                                                        "slug":"du-lich"
                                                    };
                            ObjDocument.source = urlSource;
                            ObjDocument.source_site = 'vnexpress';
                            ObjDocument.created_time    = new Date().toISOString();
                            ObjDocument.status=0;
                            data.push(ObjDocument);
                        }
                    })
                    /*if(data.length>0){
                        for(i=0;i<data.length;i++){
                            var slug = data[i].slug;
                        }
                    }*/
                    /*if(ObjDocument.slug!='' && ObjDocument.slug!=null){
                        MongoClient.connect(url, function(err, db) {
                            var collection = db.collection('posts_prepare');
                          // Find some documents
                            collection.find({slug:ObjDocument.slug}).limit(1).toArray(function(err, docs) {
                                console.log(docs);
                                if(typeof docs === 'object' && docs.length>0){
                                    console.log("Duplicated:"+ObjDocument.slug);
                                }else{
                                    
                                }
                                console.log("Found the following records");
                          });
                          db.close();
                        });
                    }*/
                    console.log('==>Begin connect mongo');
                    // Connection URL
                    
                    // Use connect method to connect to the Server
                    MongoClient.connect(url, function(err, db) {
                        //assert.equal(null, err);
                        console.log(err);
                        console.log("Connected correctly to server and start insert");
                        if(data.length>0){
                            MongoDB.insertDocuments(params.posts_prepare,db, data,function() {
                                db.close();
                                page++;
                                if(page<2){
                                    var siteUrlSource ="http://dulich.vnexpress.net/page/"+page+".html";
                                    Crawler.executed(siteUrlSource);
                                }
                                console.log('Closed connect mongo');
                                
                            });
                        }else{
                            console.log("Not Found to crawl");
                        }
                        //db.close();
                    });
                    console.log('==>end');
                }
                }
            });
        }catch(e){
            console.log('Exception:'+e);
        }
    }
}
var siteUrlSource ="http://dulich.vnexpress.net/page/1.html";
Crawler.executed(siteUrlSource);
/*var CCrawler = Crawler;
for(i=200; i>=1;i--){
    var siteUrlSource ="http://suckhoe.vnexpress.net/tin-tuc/khoe-dep/tham-my/page/"+i+".html";
    CCrawler.executed(siteUrlSource);
}*/