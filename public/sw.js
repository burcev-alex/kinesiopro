
const staticCacheName = 'static-cache-v1';
const dynamicCacheName = 'dynamic-cache-v1';

// const staticAssets = [
// 	'./',
// 	'./index.html',
// 	'./img/icons/icon-128x128.png',
// 	'./img/icons/icon-192x192.png',
// 	'./css/main.css',
// 	'./css/libs.css',
// 	'./js/main.js',
// 	'./js/libs.min.js',
// ];




self.addEventListener('install', async event =>{
	// const cache = await caches.open(staticCacheName);
	// await cache.addAll(staticAssets);
    // console.log('install sw')
	
});


self.addEventListener('activate', async event => {
    // const cachesKeys = await caches.keys();
    // const checkKeys = cachesKeys.map(async key => {
    //     if (![staticCacheName, dynamicCacheName].includes(key)) {
    //         await caches.delete(key);
    //     }
    // });
    // await Promise.all(checkKeys);
    // console.log('activate sw')
});


self.addEventListener('fetch', async event =>{
	// event.respondWith(checkCache(event.request));
    // console.log('fetch sw')
});

// async function checkCache(req) {
//     const cachedResponse = await caches.match(req);
//     return cachedResponse || checkOnline(req);
// }

// async function checkOnline(req) {
//     const cache = await caches.open(dynamicCacheName);
//     try {
//         const res = await fetch(req);
//         await cache.put(req, res.clone());
//         return res;
//     } catch (error) {
//         const cachedRes = await cache.match(req);
//         if (cachedRes) {
//             return cachedRes;
//         } else if (req.url.indexOf('.html') !== -1) {
//             return caches.match('./offline.html');
//         }
//     }
// }