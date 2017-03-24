var MongoClient = require('mongodb').MongoClient;
var MongoDB = require('./helpers/MongoDB.js');
var params = require('./config/params.js');
var Utils = require('./helpers/Utils.js');
try{
	var collection=params.category;
	var connString=params.db_conn_string;
	var ObjDocument = {};
	ObjDocument.name = "Dinh dưỡng";
	ObjDocument.slug = Utils.slug(ObjDocument.name);
	ObjDocument.parent = "";
	var urlSouce = [
					"http://suckhoe.vnexpress.net/tin-tuc/dinh-duong",
					"http://songkhoe.vn/chuyen-muc-dinh-duong-s2955-0.html",
					"http://dinhduong.com.vn/kien-thuc/",
					"http://tapchidinhduong.vn/kien-thuc.html"
					];
	ObjDocument.url_source = urlSouce;
	ObjDocument.status=1;
	ObjDocument.created_time=new Date().toISOString();

	var data = [];
	data.push(ObjDocument);
	MongoClient.connect(connString, function(err, db) {
                        console.log("Connected correctly to server and start insert");

                        MongoDB.insertDocuments(collection,db, data,function() {
                            db.close();
                            console.log('Closed connect mongo');
                        });
                    });

}catch(e){
	console.log('Exception:'+e);
}