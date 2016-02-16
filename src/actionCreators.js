import xhr from 'xhr';

// wrap xhr_request to return a promise
const xhr_promise = (url, xhr_options) => {
    return new Promise( (resolve, reject) => {
        // {post, put, patch, del, get}
        xhr.get(url, xhr_options, (err, resp, body) => {
            if (err) return reject(err);
            return resolve(body);
        });
    });
};


export const setState = (state) => {
    return {
        type: 'SET_STATE',
        state
    };
};

export const vote = (entry) => {
    return {
        type: 'VOTE',
        entry
    };
};

export const increment = () => {
    return {
        type: 'INCREMENT'
    };
};

export const someActionCreator = () => {
    return {
        type: 'FOO'
    };
};

export const someOtherActionCreator = (someParam) => {
    return {
        type: 'BAR',
        val: someParam
    };
};

let xhr_options = {
    headers: {},
    json: {}
};

export const someThunkCreator = (someParam) =>  {
    return (dispatch, getState) => {
        const myval = getState.foo.bar + someParam;
        dispatch( someActionCreator(myval) );
        xhr_promise( 'foo/bar', xhr_options)
            .then( result => dispatch( someOtherActionCreator(result) ))
            .catch( err => dispatch( someOtherActionCreator(err) ) );
    };
};



