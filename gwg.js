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