import 'whatwg-fetch';
import './app.css';
import Preact from 'preact';
import App from './App';

// root holds our app's root DOM Element:
let root;

function init() {
    root = Preact.render(<App />, document.getElementById('app'), root);
}
init();

// example: Re-render on Webpack HMR update:
if (module.hot) module.hot.accept('./App', init);
