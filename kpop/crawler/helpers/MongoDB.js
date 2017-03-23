var MongoDB = {
    insertDocuments: function(collection_name, db, dataObj, callback) {
        // Get the documents collection
        var collection = db.collection(collection_name);
        // Insert some documents
        collection.insertMany(dataObj, function(err, result) {
            /*assert.equal(err, null);
            assert.equal(3, result.result.n);
            assert.equal(3, result.ops.length);*/
            if(err==null){
                console.log("Insert success!");
                //console.log(result.ops);
                console.log("Inserted "+result.result.n+" | length:"+result.ops.length);
            }else{
                console.log("Insert fail!"+err);
            }

            
            callback(result);
        });
    },
    findDocuments: function(collection_name,db,condition,limit,callback) {
      // Get the documents collection
      var collection = db.collection(collection_name);
      // Find some documents with object condition
      collection.find(condition).limit(limit).toArray(function(err, docs) {
        /*assert.equal(err, null);
        assert.equal(2, docs.length);*/
        //console.log("Found the following records");
        //console.dir(docs);
        callback(docs);
      });
    },
    updateDocument: function(db, callback) {
      // Get the documents collection
      var collection = db.collection('documents');
      // Update document where a is 2, set b equal to 1
      collection.updateOne({ a : 2 }
        , { $set: { b : 1 } }, function(err, result) {
        assert.equal(err, null);
        assert.equal(1, result.result.n);
        console.log("Updated the document with the field a equal to 2");
        callback(result);
      });  
    }
}
module.exports = MongoDB;