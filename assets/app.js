/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './scss/app.scss';

// start the Stimulus application
import './bootstrap';

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register(window.location.origin + '/sw.js')
      .then(function () {console.log('Enregistrement reussi.')})
      .catch(function (e) {console.error(e)});
  }