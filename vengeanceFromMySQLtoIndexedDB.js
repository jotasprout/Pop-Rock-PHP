// FROM THE QUESTION

 function openPHPdatabase () {
    console.log ('well, that did not work');
}

// FROM THE ANSWER
// Asynchronously open a connection to indexedDB
function openIndexedDBDatabase() {
    return new Promise(function(resolve, reject) {
      const request = indexedDB.open('heavens-metal', 1);
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
        const transaction = db.transaction('metal', 'readwrite');
        transaction.oncomplete = () => resolve();
        transaction.onerror = () => reject(transaction.error);
        const store = transaction.objectStore('metal');
        for(let obj of data) {
          store.put(obj);
        }
     });
   }
   
   // Asynchronously do all the things together
   async function doStuff() {
      if(!navigator.onLine) {
         const data = await getJsonAsync('albumsForIndexedDB.php');
         const db = await openIndexedDBDatabase();
         await storeTheDataInIndexedDb(db, data);
         db.close();
      } else {
         openPHPdatabase();
      }
   }
   
   // doStuff();