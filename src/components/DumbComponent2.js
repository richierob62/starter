import React from 'react';
import { Link } from 'react-router'

export default class DumbComponent2 extends React.Component {

    render() {
        return (
            <div>
                <h1 style={{ color: 'green' }}>Hello From Users!! </h1>
                <h2>{this.props.three_a}</h2>
                <Link to='/'>Home</Link>
            </div>
        );
    }
}
