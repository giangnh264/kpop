var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var sanitizeHtml = require('sanitize-html');

var Utils = require('./helpers/Utils.js');
var params = require('./config/params.js');

var jquery = fs.readFileSync("jquery.min.js", "utf-8");
var dateTime = require('node-datetime');
var dt = dateTime.create();
dt.format('m/d/Y H:M:S');

var connection = mysql.createConnection(params);
connection.connect();

try {


    var posts_prepare = params.posts_prepare;
    var posts = params.posts;
    var connString = params.db_conn_string;
    console.log("==>Begin get posts prepare to crawl");

    var url_list = [];
    var Posts = {
        crawl: function () {
            connection.connect();
            connection.query('SELECT * FROM original_url WHERE crawler_status = 0 ORDER BY updated_time DESC LIMIT 100', function (error, results) {
                if (error) throw error;
                for (var i = 0, len = results.length; i < len; i++) {
                    var page = results[i].original_url;
                    CrawlPostsDetail(page, results[i]);
                }
            });
        }

    }


    function CrawlPostsDetail(urlSite, original_url_obj) {
        if (urlSite != '' && urlSite != null) {

            jsdom.env({
                url: urlSite,
                src: [jquery],
                done: function (err, window) {
                    console.log('==>Begin Crawler on: ' + urlSite);
                    if (typeof window === 'object') {
                        var $ = window.$;


                        //lay content
                        var mainContent = $("#wrapper");
                        mainContent.find("#pollArticleDetail").remove();

                        var content = sanitizeHtml(mainContent.find(".content-news-detail").html(), {
                            allowedTags: ['b', 'i', 'em', 'strong', 'p', 'img', 'iframe'],
                            allowedAttributes: {
                                'img': ['src']
                            }
                        });
                        // content = content.find("#pollArticleDetail").remove();
                        content = content.trim();

                        var description = mainContent.find(".content-news-detail .sapo").html();
                        description = description.trim();

                        var title = sanitizeHtml(mainContent.find(".folder-title-news-detail h1").text(), {
                            allowedTags: ['b', 'i', 'em', 'strong', 'p', 'img'],
                            allowedAttributes: {
                                'img': ['src']
                            }
                        });
                        title = title.replace(/(\r\n|\n|\r|\t|\&quot;)/gm,"").trim();

                        console.log(title);

                        var news_obj = {
                            title:title,
                            description:description,
                            content:content,
                            category_id: original_url_obj.category_id,
                            created_time: new Date(dt.now()),
                            updated_time: new Date(dt.now()),
                        };

                        var query = connection.query('INSERT INTO news SET ?', news_obj, function (error, result) {
                            if (error) throw error;
                            var news_id = result.insertId;

                            // lay tag
                            var mainTag = $("#wrapper");

                            var dom_tag_before = mainTag.find(".folder-title-news-detail .tags a");
                            dom_tag_before.each(function (index) {
                                var tag_before = $(this).text();
                                tag_before = tag_before.replace(/(\r\n|\n|\r|\t|\#)/gm, "").trim();
                                var name_array_before = {
                                    name: tag_before
                                };
                                console.log('----------------------------name_array_before----------------------------------');

                                console.log(name_array_before);
                                var query = connection.query('SELECT * FROM tag WHERE name = ?', name_array_before.name, function (error, results, fields) {
                                    if (error) throw error;
                                    if (results.length == 0) {
                                        var query = connection.query('INSERT INTO tag SET ?  ON DUPLICATE KEY UPDATE status=1', name_array_before, function (error, result) {
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

                                console.log('----------------------------tag_after----------------------------------');

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
                                                news_id: news_id
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
                                            news_id: news_id
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
                            var original_img = original_url_obj.original_img;
                            var fileType = Utils.getFileType(original_img);
                            var pathStorage = Utils.getPathStorage();
                            if (!fs.existsSync(pathStorage)) {
                                mkdirp.sync(pathStorage);
                            }
                            var pathFile = pathStorage + params.DS + news_id + '.' + fileType;
                            var pathUrl = pathFile.replace(params.storage, '');
                            console.log('pathUrl:' + pathUrl);
                            // imgFullText[':img-'+i] = pathUrl;
                            console.log('download to:' + pathFile);
                            /*if(fs.existsSync(pathFile)){
                             fs.unlinkSync(pathFile);
                             }*/

                            Utils.download(original_img, pathFile, function (res) {
                                // console.log('download callback:' + res);
                                //update db
                                connection.query('UPDATE news SET url_img = ? WHERE id = ?', [pathUrl, news_id], function (error, results, fields) {
                                    if (error) throw error;
                                    // ...
                                });
                            });

                        });

                        connection.query('UPDATE original_url SET crawler_status = 1 WHERE original_url = ?', [original_url_obj.original_url], function (error, results, fields) {
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
