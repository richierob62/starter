import { Map } from 'immutable';

export function setState(state, newState) {
    return state.merge(newState);
}

export const INITIAL_STATE_3B = new Map({
    three_b: 'value of three_b'
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

export default function three_b(state = INITIAL_STATE_3B, action) {
    switch (action.type) {
        case 'SOME_ACTION_3_A':
            return some_core_function_3(state, action.some_param_3)
        case 'SOME_ACTION_3_B':
            return some_core_function_4(state, action.some_param_4)
        default:
            return state;
    }
};

