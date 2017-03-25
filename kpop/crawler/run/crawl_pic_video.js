var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var sanitizeHtml = require('sanitize-html');

var Utils = require('../helpers/Utils.js');
var params = require('../config/params.js');

var jquery = fs.readFileSync("../factory/jquery.min.js", "utf-8");

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
            connection.query('SELECT * FROM category WHERE status = 1 AND (id = 4 OR id = 7) ORDER BY id DESC', function (error, results, fields) {
                if (error) throw error;
                    // getListUrl(results);
                async.each(results, getListUrl);

            });
        },
    }
	
    function getListUrl(url_obj) {
        var data = [];
            for (var j = 20;  j >= 1; j--) {
                var url = url_obj.original_url + '/trang-' + j + '.html' ;
                if(j==1) url = url_obj.original_url + '.html' ;
                var obj_category = {
                    category_id:url_obj.id,
                    original_url:url,
                    original_domain: url_obj.original_domain
                };
                data.push(obj_category);
            }
        /*var url = url_obj.original_url + '.html' ;
        var obj_category = {
            category_id:url_obj.id,
            original_url:url,
            original_domain: url_obj.original_domain
        };*/
        data.push(obj_category);
        async.each(data, CrawlPostsDetail);

    }
    function CrawlPostsDetail(docs, callback_fs){
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

                            var dom = mainContent.find("ul.group-prd li .box-prd");

                            var total = [];
                            dom.each(function (index) {
                                var ObjDocument = {};

                                var original_url = $(this).find(".content .title a").attr("href");

                                // original_url = original_url.replace(/(\r\n|\n|\r|\t|\/)/gm,"");

                                original_url = docs.original_domain + original_url;

                                var original_img = $(this).find(".image img").attr("src");

                                    original_img = original_img.replace(/(555x416|262x197|555x37)/gm, '760x430');
                                    // original_img = original_img.replace(/262x197/gm, '760x430');
                                    // original_img = original_img.replace(/555x370/gm, '760x430');
                                console.log(original_img);

                                var post = {
                                    original_url: original_url,
                                    original_img: original_img,
                                    category_id: docs.category_id,
                                    created_time: new Date(dt.now()),
                                    updated_time: new Date(dt.now()),
                                };

                                // console.log(post);

                                var query = connection.query('SELECT * FROM original_url WHERE original_url = ?', post.original_url ,function (error, results, fields) {
                                    if (error) throw error;
                                    if(results.length == 0){
                                        // callback_fs(post);
                                        var query = connection.query('INSERT INTO original_url SET ?  ON DUPLICATE KEY UPDATE updated_time = ?', [post, post.updated_time], function (error, result) {
                                            if (error) throw error;
                                            // Neat!
                                            // connection.end();
                                            console.log('INSERTED' + result.insertId);
                                        });
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

}catch(e)
{
	console.log('Exception: '+e);
}

Posts.crawl();
