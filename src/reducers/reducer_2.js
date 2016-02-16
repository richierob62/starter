import { Map } from 'immutable';

export function setState(state, newState) {
    return state.merge(newState);
}

export const INITIAL_STATE_2 = new Map({
    foo: 'bar'
});

export function vote(state, entry) {
    const currentPair = state.getIn(['vote', 'pair']);
    if (currentPair && currentPair.includes(entry)) {
        return state.set('hasVoted', entry);
    } else {
        return state;
    }
}

export function resetVote(state) {
    const hasVoted = state.get('hasVoted');
    const currentPair = state.getIn(['vote', 'pair'], List());
    if (hasVoted && !currentPair.includes(hasVoted)) {
        return state.remove('hasVoted');
    } else {
        return state;
    }
}

export default function reducer_2(state = INITIAL_STATE_2, action) {
    switch (action.type) {
        case 'SOME_ACTION_2_A':
            return some_function_1(state, action.some_param)
        case 'SOME_ACTION_2_B':
            return some_function_2(state, action.some_param_2)
        default:
            return state;
    }
};
