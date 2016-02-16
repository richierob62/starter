// Libraries
import React from 'react';
import thunk from 'redux-thunk';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import { createDevTools } from 'redux-devtools';
import counter from './reducers/counter';
import reducer_2 from './reducers/reducer_2';
import three_a from './reducers/three_a';
import three_b from './reducers/three_b';
import LogMonitor from 'redux-devtools-log-monitor';
import DockMonitor from 'redux-devtools-dock-monitor';
import { syncHistory, routeReducer } from 'react-router-redux';
import { Router, Route, browserHistory, IndexRoute } from 'react-router';
import { compose, createStore, combineReducers, applyMiddleware } from 'redux';


// Components
import App from './components/App';
import NoMatch from './components/NoMatch';
import SomeSmartComponent from './components/SomeSmartComponent';
import SomeSmartComponent2 from './components/SomeSmartComponent2';

// styles and fonts
require('./styles/styles.scss');

// jquery and bootstrap scripts
// var $ = require('jquery');
// window.jQuery = $;
// window.$ = $;
// require('bootstrap');

// // Sync dispatched route actions to the history
const reduxRouterMiddleware = syncHistory(browserHistory);

// combine reducers
const reducer = combineReducers({
  counter,
  reducer_2,
  three_a,
  three_b,
  routing: routeReducer
})



// change this line for production!!
const  mode = 'test';

const DevTools = createDevTools(
  <DockMonitor toggleVisibilityKey='ctrl-h'
               changePositionKey='ctrl-q'>
    <LogMonitor theme='tomorrow' />
  </DockMonitor>
);

// install middleware
let middleware = [thunk, reduxRouterMiddleware];
let createStoreWithMiddleware;

if (mode === 'production') {
    createStoreWithMiddleware = applyMiddleware(...middleware)(createStore);
} else {
    createStoreWithMiddleware = compose(
      applyMiddleware(...middleware),
      DevTools.instrument()
    )(createStore);
}

const store = createStoreWithMiddleware(reducer);

const routes =  <Route path="/" component={App}>
                    <IndexRoute component={SomeSmartComponent} />
                    <Route path="about" component={SomeSmartComponent}/>
                    <Route path="users" component={SomeSmartComponent2}>
                        <Route path="/user/:userId" component={SomeSmartComponent}/>
                    </Route>
                    <Route path="*" component={NoMatch}/>
                </Route>;

// Required for replaying actions from devtools to work
reduxRouterMiddleware.listenForReplays(store);

ReactDOM.render(
  <Provider store={store}>
    <div>
      <Router history={browserHistory}>{routes}</Router>
      <DevTools />
    </div>
  </Provider>,
  document.getElementById('app')
);

// read location from state:
// state.routing.location.pathname
//
// to change route:
// import { routeActions } from 'react-router-redux'
// dispatch(routeActions.push('/foo'))
//
// respond to route change
// import { UPDATE_LOCATION } from 'react-router-redux'
// in reducer:
// case UPDATE_LOCATION:
