var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var sanitizeHtml = require('sanitize-html');

var Utils = require('./helpers/Utils.js');
var params = require('./config/params.js');

var jquery = fs.readFileSync("jquery-1.12.1.min.js", "utf-8");

var dateTime = require('node-datetime');
var dt = dateTime.create();
dt.format('m/d/Y H:M:S');

var mysql      = require('mysql');
var connection = mysql.createConnection(params);
connection.connect();

var async = require('async');
try{

    var Posts = {
        crawl: function(){
            connection.query('SELECT * FROM category WHERE status = 1 ORDER BY id DESC', function (error, results, fields) {
                if (error) throw error;
                    // getListUrl(results);
                async.each(results, getListUrl);

            });
        },
    }
	
    function getListUrl(url_obj) {
        var data = [];
            for (var j = 10;  j >= 1; j--) {
                var url = url_obj.original_url + '/trang-' + j + '.html' ;
                if(j==1) url = url_obj.original_url + '.html' ;
                var obj_category = {
                    category_id:url_obj.id,
                    original_url:url
                };
                data.push(obj_category);
                // console.log(obj_category);
                // CrawlPostsDetail(obj_category);
            }

        async.each(data, CrawlPostsDetail);


    }
    function CrawlPostsDetail(docs, callback_fs){
        // console.log(docs);
        var urlSite = docs.original_url;
    	if(urlSite!='' && urlSite!=null){
    		jsdom.env({
                url: urlSite,
                src: [jquery],
                done: function (err, window) {
                    if(typeof window === 'object'){
                        console.log('=====>Begin Crawler on: '+urlSite +'<=====');
                        if(typeof window === 'object'){
                            var $ = window.$;
                            var data = [];
                            var mainContent = $("#wrapper");
                            mainContent.find(".set-relative ").remove();

                            var dom = mainContent.find("ul.article-list li .box-prd");

                            var total = [];
                            dom.each(function (index) {
                                var ObjDocument = {};

                                var original_url = $(this).find(".content .title a").attr("href");
                                original_url = original_url.replace(/(\r\n|\n|\r|\t|\/)/gm,"");

                                var title = sanitizeHtml($(this).find(".content .title a").text(), {
                                    allowedTags: [ 'b', 'i', 'em', 'strong', 'p','img' ],
                                    allowedAttributes: {
                                        'img': ['src']
                                    }
                                });

                                var desctription = sanitizeHtml($(this).find(".content p.premise").text(), {
                                    allowedTags: [ 'b', 'i', 'em', 'strong', 'p','img' ],
                                    allowedAttributes: {
                                        'img': ['src']
                                    }
                                });

                                title = title.replace(/(\r\n|\n|\r|\t|\&quot;)/gm,"").trim();

                                desctription = desctription.replace(/(\r\n|\n|\r|\t|\&quot;)/gm,"").trim();

                                var original_img = $(this).find(".image img").attr("src");
                                var original_img = original_img.replace(/262x197/g, '760x430');

                                // console.log(title);
                                var post = {
                                    title: title,
                                    original_url: original_url,
                                    original_img: original_img,
                                    description: desctription,
                                    category_id: docs.category_id,
                                    created_time: new Date(dt.now()),
                                    updated_time: new Date(dt.now()),
                                };

                                // console.log(post);

                                var query = connection.query('SELECT * FROM news WHERE original_url = ?', post.original_url ,function (error, results, fields) {
                                    if (error) throw error;
                                    if(results.length == 0){
                                        // callback_fs(post);
                                        var query = connection.query('INSERT INTO news SET ?', post, function (error, result) {
                                            if (error) throw error;
                                            // Neat!
                                            // connection.end();
                                            console.log('INSERTED' + result.insertId);
                                        });
                                        connection.destroy();
                                    }else{
                                        // console.log('da ton tai');
                                    }
                                });
                            });
                        }
                    }
                }
            })
    	}else{
            console.log("siteUrl Null: "+urlSite);
        }
    }

    function ProcessData(data_obj) {
        console.log(data_obj);
        console.log('================GIANGNH==================');
        /*var query = connection.query('SELECT * FROM news WHERE original_url = ?', data_obj.original_url ,function (error, results, fields) {
            if (error) throw error;
            if(results.length == 0){
                var query = connection.query('INSERT INTO news SET ?', data_obj, function (error) {
                    if (error) throw error;
                    // Neat!
                    // connection.end();
                });
            }else{
                console.log('da ton tai');
            }
        });*/
    }

    function callback_fs(data) {
        console.log(data);
    }
}catch(e)
{
	console.log('Exception: '+e);
}

Posts.crawl();
