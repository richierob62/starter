import {
    Map
}
from 'immutable';

function setState(state, newState) {
    return state.merge(newState);
}

const INIT = new Map({
    counter: 0
});

function increment(state) {
    let prev = state.get('counter');
    return state.set('counter', prev + 1);
}

export default function counter(state = INIT, action) {

    const { type } = action;

    switch (type) {
    case 'INCREMENT':
        return increment(state);
    case 'SOME_ACTION_1_B':
        return some_function_0(state, action.some_param);
    default:
        return state;
    }
}
