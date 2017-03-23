var mysql = require('mysql');
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'kpop'
});


var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var sanitizeHtml = require('sanitize-html');

var Utils = require('./helpers/Utils.js');
var params = require('./config/params.js');

var jquery = fs.readFileSync("jquery-1.12.1.min.js", "utf-8");

try {


    var posts_prepare = params.posts_prepare;
    var posts = params.posts;
    var connString = params.db_conn_string;
    console.log("==>Begin get posts prepare to crawl");

    var url_list = [];
    var Posts = {
        crawl: function () {
            connection.connect();
            connection.query('SELECT * FROM news WHERE status = 1 AND content IS NULL OR url_img IS NULL OR title IS NULL ORDER BY id DESC LIMIT 50 ', function (error, results) {
                if (error) throw error;
                for (var i = 0, len = results.length; i < len; i++) {
                    var page = results[i].original_url;
                    // var news_id = results[i].id;
                    page = 'http://tintuckpop.net/' + page;
                    CrawlPostsDetail(page, results[i]);
                }
            });
            /*(function loop() {

                connection.query('SELECT * FROM news WHERE status = 1 AND content IS NULL OR url_img IS NULL OR title IS NULL ORDER BY id DESC LIMIT 10', function (error, results) {
                    if (error) throw error;
                    if(results.length >0 ){
                        for (var i = 0, len = results.length; i < len; i++) {
                            var page = results[i].original_url;
                            // var news_id = results[i].id;
                            page = 'http://tintuckpop.net/' + page;
                            CrawlPostsDetail(page, results[i]);
                        }
                        loop();
                    }

                });
            }());*/
        }

    }


    function CrawlPostsDetail(urlSite, news_obj) {
        if (urlSite != '' && urlSite != null) {

            jsdom.env({
                url: urlSite,
                src: [jquery],
                done: function (err, window) {
                    console.log('==>Begin Crawler on: ' + urlSite);
                    if (typeof window === 'object') {
                        var $ = window.$;
                        var data = [];
                        // lay tag
                        var mainTag = $("#wrapper");

                        var dom_tag_before = mainTag.find(".folder-title-news-detail .tags a");
                        dom_tag_before.each(function (index) {
                            var tag_before = $(this).text();
                            tag_before = tag_before.replace(/(\r\n|\n|\r|\t|\#)/gm, "").trim();
                            var name_array_before = {
                                name: tag_before
                            };
                            console.log(name_array_before);
                            var query = connection.query('SELECT * FROM tag WHERE name = ?', name_array_before.name, function (error, results, fields) {
                                if (error) throw error;
                                if (results.length == 0) {
                                    var query = connection.query('INSERT INTO tag SET ?  ON DUPLICATE KEY UPDATE status=1', name_array_before, function (error, result) {
                                        if (error) throw error;
                                        // Neat!
                                        var relation_news_tag = {
                                            tag_id: result.insertId,
                                            news_id: news_obj.id
                                        };

                                        var query = connection.query('INSERT INTO relations_tag_news SET ?', relation_news_tag, function (error) {
                                            if (error) throw error;
                                            // Neat!
                                            // connection.end();

                                        });
                                        // connection.end();

                                    });
                                } else {
                                    var tag_id = results[0].id;
                                    //check relation tag news
                                    var relation_news_tag = {
                                        tag_id: tag_id,
                                        news_id: news_obj.id
                                    };
                                    var query = connection.query('SELECT * FROM relations_tag_news WHERE tag_id = ? AND news_id = ?', [name_array_before.tag_id, name_array_before.news_id], function (error, results, fields) {
                                        if (error) throw error;
                                        if (results.length == 0) {
                                            var query = connection.query('INSERT INTO relations_tag_news SET ? ON DUPLICATE KEY UPDATE status=1', relation_news_tag, function (error) {
                                                if (error) throw error;
                                                // Neat!
                                                // connection.end();

                                            });
                                        }
                                    });
                                }
                            });
                        });

                        var dom_tag_after = mainTag.find(".tags-detail a.transition");
                        dom_tag_after.each(function (index) {
                            var tag_after = $(this).text();
                            tag_after = tag_after.replace(/(\r\n|\n|\r|\t|\#)/gm, "").trim();

                            console.log(tag_after);
                            var name_array_before = {
                                name: tag_after
                            };
                            // console.log(name_array_before);
                            var query = connection.query('SELECT * FROM tag WHERE name = ?', name_array_before.name, function (error, results, fields) {
                                if (error) throw error;
                                if (results.length == 0) {
                                    var query = connection.query('INSERT INTO tag SET ?', name_array_before, function (error, result) {
                                        if (error) throw error;
                                        // Neat!
                                        var relation_news_tag = {
                                            tag_id: result.insertId,
                                            news_id: news_obj.id
                                        };

                                        var query = connection.query('INSERT INTO relations_tag_news SET ? ON DUPLICATE KEY UPDATE status=1', relation_news_tag, function (error) {
                                            if (error) throw error;
                                            // Neat!
                                            // connection.end();

                                        });
                                        // connection.end();

                                    });
                                } else {
                                    var tag_id = results[0].id;
                                    //check relation tag news
                                    var relation_news_tag = {
                                        tag_id: tag_id,
                                        news_id: news_obj.id
                                    };
                                    var query = connection.query('SELECT * FROM relations_tag_news WHERE tag_id = ? AND news_id = ?', [name_array_before.tag_id, name_array_before.news_id], function (error, results, fields) {
                                        if (error) throw error;
                                        if (results.length == 0) {
                                            var query = connection.query('INSERT INTO relations_tag_news SET ? ON DUPLICATE KEY UPDATE status=1', relation_news_tag, function (error) {
                                                if (error) throw error;
                                                // Neat!
                                                // connection.end();

                                            });
                                        }
                                    });
                                }
                            });
                        });

                        //img
                        var fileType = Utils.getFileType(news_obj.original_img);
                        var pathStorage = Utils.getPathStorage();
                        if (!fs.existsSync(pathStorage)) {
                            mkdirp.sync(pathStorage);
                        }
                        var pathFile = pathStorage + params.DS + news_obj.id + '.' + fileType;
                        var pathUrl = pathFile.replace(params.storage, '');
                        console.log('pathUrl:' + pathUrl);
                        // imgFullText[':img-'+i] = pathUrl;
                        console.log('download to:' + pathFile);
                        /*if(fs.existsSync(pathFile)){
                         fs.unlinkSync(pathFile);
                         }*/
                        Utils.download(news_obj.original_img, pathFile, function (res) {
                            // console.log('download callback:' + res);
                            //update db
                            connection.query('UPDATE news SET url_img = ? WHERE id = ?', [pathUrl, news_obj.id], function (error, results, fields) {
                                if (error) throw error;
                                // ...
                            });
                        });
                        //lay content
                        var mainContent = $("#wrapper");
                        mainContent.find("#pollArticleDetail").remove();
                        mainContent.find(".tags-detail").remove();

                        var content = sanitizeHtml(mainContent.find(".content-news-detail").html(), {
                            allowedTags: ['b', 'i', 'em', 'strong', 'p', 'img', 'iframe'],
                            allowedAttributes: {
                                'img': ['src']
                            }
                        });
                        content = content.trim();

                        var title = sanitizeHtml(mainContent.find(".folder-title-news-detail h1").text(), {
                            allowedTags: ['b', 'i', 'em', 'strong', 'p', 'img'],
                            allowedAttributes: {
                                'img': ['src']
                            }
                        });
                        title = title.replace(/(\r\n|\n|\r|\t|\&quot;)/gm,"").trim();
                        console.log(title);
                        connection.query('UPDATE news SET content = ?, title = ? WHERE id = ?', [content, title, news_obj.id], function (error, results, fields) {
                            if (error) throw error;
                            // ...
                        });
                    }
                }
            })
        } else {
            console.log("siteUrl Null: " + urlSite);
        }

    }

    function updateTag(tag_array, news_id) {
        for (var i = 0; i < tag_array.length; i++) {
            var name_array_before = {
                name: tag_array[i]
            };
            console.log(name_array_before);
            var query = connection.query('SELECT * FROM tag WHERE name = ?', name_array_before.name, function (error, results, fields) {
                if (error) throw error;
                if (results.length == 0) {
                    var query = connection.query('INSERT INTO tag SET ?', name_array_before, function (error, result) {
                        if (error) throw error;
                        // Neat!
                        var relation_news_tag = {
                            tag_id: result.insertId,
                            news_id: news_id
                        };

                        var query = connection.query('INSERT INTO relations_tag_news SET ?', relation_news_tag, function (error) {
                            if (error) throw error;
                            // Neat!
                            // connection.end();

                        });
                        // connection.end();

                    });
                } else {
                    var tag_id = results[0].id;
                    //check relation tag news
                    var relation_news_tag = {
                        tag_id: tag_id,
                        news_id: news_id
                    };
                    var query = connection.query('SELECT * FROM relations_tag_news WHERE tag_id = ? AND news_id = ?', [name_array_before.tag_id, name_array_before.news_id], function (error, results, fields) {
                        if (error) throw error;
                        if (results.length == 0) {
                            var query = connection.query('INSERT INTO relations_tag_news SET ?', relation_news_tag, function (error) {
                                if (error) throw error;
                                // Neat!
                                // connection.end();

                            });
                        }
                    });
                }
            });
        }
    }
} catch (e) {
    console.log('Exception: ' + e);
}

Posts.crawl();
