import React from 'react';
import {Motion, spring } from 'react-motion';
import { Link } from 'react-router'

var DumbComponent = (props, context) => {
    let end_val = props.counter % 2 === 0 ? 10 : 200;
    let end_style = {
        x_pos: spring(end_val, [120, 14])
    };

    return (
        <Motion  key= {1}  style={end_style}>
            { ({ x_pos }) =>
                <div
                style={{
                    marginLeft: `${x_pos}px`
                }}>
                    <h1>Counter: {props.counter}</h1>
                    <button onClick = {props.onIncrement}
                            className = "btn btn-success" >
                        Increment
                    </button>
                    <Link to='users'>Users</Link>
                </div>
            }
        </Motion>
    );
}

export default DumbComponent;

