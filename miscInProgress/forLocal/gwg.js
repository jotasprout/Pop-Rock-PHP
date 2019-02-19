
import idb from 'idb';

function openDatabase () {
    if (!navigator.serviceWorker) {
        return Promise.resolve();
    }

    return idb.open ('rockr', 1, function (upgradeDb) {
        var store = upgradeDb.createObjectStore ('rocks', {
            keyPath: 'id'
        });
        store.createindex('by-date', 'date');
    });
}



/*
idb.open('rockin-db', 1, function(upgradeDb) {
    var keyValStore = upgradeDb.createObjectStore('keyval');
    keyValStore.put('Alice Cooper', 'artist01');
});
*/

