import { Component } from 'react';
import { connect } from 'react-redux';
import DumbComponent2 from '../components/DumbComponent2';

// Which part of the Redux global state does our component want to receive as props?
function mapStateToProps(state) {
  return {
    three_a: state.three_a
  };
}

// Which action creators does it want to receive by props?
function mapDispatchToProps(dispatch) {
  return {

  };
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(DumbComponent2);