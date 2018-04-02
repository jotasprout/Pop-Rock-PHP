function openDatabase () {
    return idb.open('rock', 1, function(upgradeDb) {
        var store = upgradeDb.createObjectStore('artistsPop', {
            keyPath: 'artistID'
        });
        items.forEach(function(item) {
            store.put(item);
        })
    });
}

dbPromise = openDatabase();

fetch ('fetchingArtists.php').(function(response) {
    let jsonData = response.json();
    // put jsonData into IndexedDB
})


// FROM SO

// Asynchronously open a connection to indexedDB
function openIndexedDBDatabase() {
    return new Promise(function(resolve, reject) {
      const request = indexedDB.open('dbname', dbversionnumber);
      request.onsuccess = () => resolve(request.result);
      request.onerror() = () => reject(request.error);
    });
   }
   
   // Asynchronously fetch some json data
   function getJsonAsync(url) {
     return new Promise(function(resolve, reject) {
       $.getJSON(url, resolve);
     });
   }
   
   // Asynchronously store the data in indexedDB
   function storeTheDataInIndexedDb(db, data) {
     return new Promise(function(resolve, reject) {
        const transaction = db.transaction('storename', 'readwrite');
        transaction.oncomplete = () => resolve();
        transaction.onerror = () => reject(transaction.error);
        const store = transaction.objectStore('storename');
        for(let obj of data) {
          store.put(obj);
        }
     });
   }
   
   // Asynchronously do all the things together
   async function doStuff() {
      if(!navigator.onLine) {
         const data = await getJsonAsync('./php/database.php');
         const db = await openIndexedDBDatabase();
         await storeTheDataInIndexedDb(db, data);
         db.close();
      } else {
         openPHPdatabase();
      }
   }
   
   doStuff();