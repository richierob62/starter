import React from 'react';
import { connect } from 'react-redux';
import { routeActions } from 'react-router-redux';

class App extends React.Component {

  render() {
    return (
        <div>
            <h1>Hello from App</h1>
            {this.props.children}
        </div>
    );
  }

}

export default connect(
  null,
  routeActions
)(App);
