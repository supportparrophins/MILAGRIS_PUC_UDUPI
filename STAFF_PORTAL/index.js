if('serviceWorker' in navigator) {

  navigator.serviceWorker

      .register('sw.js')

      .then(function() { console.log('Service Worker Registered'); });

}

// Detects if device is on iOS 

const isIos = () => {

  const userAgent = window.navigator.userAgent.toLowerCase();

  return /iphone|ipad|ipod/.test( userAgent );

}

// Detects if device is in standalone mode

const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);



// console.log("isIos-",isIos());

// console.log("isInStandaloneMode-",isInStandaloneMode());



let deferredPrompt;

const addBtn = document.querySelector('#sjpuch_bang_staff_add_btn');

addBtn.style.display = 'none';

  

window.addEventListener('beforeinstallprompt', (e) => {

  e.preventDefault();

  deferredPrompt = e;

  addBtn.style.display = 'block';

});



addBtn.addEventListener('click', (e) => {

  addBtn.style.display = 'none';

  deferredPrompt.prompt();

  deferredPrompt.userChoice.then((choiceResult) => {

      if (choiceResult.outcome === 'accepted') {

        console.log('User accepted the A2HS prompt');

      } else {

        console.log('User dismissed the A2HS prompt');

      }

      deferredPrompt = null;

    });

});

  