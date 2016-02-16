import React from 'react';
import { Motion, spring } from 'react-motion';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import { increment } from '../actionCreators';
import { createSelector } from 'reselect';

class DumbComponent extends React.Component {

        render() {

            let end_val = this.props.counter.get('counter') % 2 === 0 ? 10 : 200;

            let end_style = {
                x_pos: spring(end_val, [120, 14])
            };

            return (
                <Motion  key= {1}  style={end_style}>
                    {
                        ( { x_pos } )  => {
                            return (
                                <div
                                    style={{
                                        marginLeft: `${x_pos}px`
                                    }}>
                                    <h1>Counter at: {this.props.counter.get('counter')}</h1>
                                    <button onClick = {this.props.onIncrement}
                                            className = "btn btn-success" >
                                        Increment
                                    </button>
                                    <Link to='users'>Users</Link>
                                </div>
                            );

                        }
                    }
                </Motion>
            );
        }
}

// url data on props:
// e.g. props.location.query.filter
// const counterSelector = (state, props) => state.counter;
const counterSelector = (state) => state.counter;
const reducer_2Selector = (state) => state.reducer_2;
const mapStateToProps = createSelector(
  counterSelector,
  reducer_2Selector,
  (counter, reducer_2) => ( { counter: counter, foo: reducer_2 })
);

// Which action creators does it want to receive by props?
// const mapDispatchToProps = (dispatch, ownProps) => {
const mapDispatchToProps = (dispatch) => {
    return {
        onIncrement: () => dispatch(increment())
    };
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(DumbComponent);