import counter  from './counter';
import reducer_2 from './reducer_2';
import three_a from './three_a';
import three_b from './three_b';
import { combineReducers } from 'redux';

let rootReducer = combineReducers({
    counter,
    reducer_2,
    theThrees : combineReducers({
                    three_a,
                    three_b
                })
});

export default rootReducer;
