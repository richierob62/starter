// rcc→    class component skeleton
import React from 'react';

export class babel-snippets extends React.Component {

    render() {
        return (
            <div></div>
        );
    }

}
// rcc→    legacy component skeleton
import React from 'react';

export const babel-snippets = React.createClass({
    // ren→    render() {…}
    render() {
        return (
            <div></div>
        );
    },
    // cdm→    componentDidMount() {…}
    componentDidMount() {
        // sst→    this.setState(…)
        this.setState((state, props) => );
        // props→  this.props
        this.props.
        // state→  this.this.state
        this.state.
    },
    // cdup→   componentDidUpdate(prevProps, prevState) {…}
    componentDidUpdate(prevProps, prevState) {

    },
    // cwm→    componentWillMount() {…}
    componentWillMount() {
        // fdn→    React.findDOMNode(…)
        React.findDOMNode(this)

    },
    // cwr→    componentWillReceiveProps(nextProps) {…}
    componentWillReceiveProps(nextProps) {

    },
    // cwun→   componentWillUnmount() {…}
    componentWillUnmount() {

    },
    // cwup→   componentWillUpdate(nextProps, nextState) {…}
    componentWillUpdate(nextProps, nextState) {

    },
    // gdp→    getDefaultProps() {…}
    getDefaultProps() {
        return {};
    },
    // gis→    getInitialState() {…}
    getInitialState() {
        return {};
    },
    // scu→    shouldComponentUpdate(nextProps, nextState) {…}
    shouldComponentUpdate(nextProps, nextState) {
        return false;
    },

});

