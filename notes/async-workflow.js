import xhr from 'xhr';

let xhr_options = {
    headers: Object?,
    json: Object?
};

// wrap xhr_request to return a promise
xhr_promise(url, xhr_options, xhr_callback) {
    return new Promise( (resolve, reject) => {
        // {post, put, patch, del, get}
        xhr.get(url, xhr_options, (err, resp, body) => {
          if (err) return reject(err);
          return resolve(body);
        });
    });
}

function someThunkMethod() {
    return (dispatch, getState) => {
        dispatch( someActionCreator() );
        xhr_promise()
            .then( result => dispatch( someOtherActionCreator() ))
            .catch( err => dispatch( someOtherActionCreator() ) );
    }
}

function mapStateToProps(state, ownProps) {
    return {
        somePropPassedToChildren: state.someValueOnState
    };
}

function mapDispatchToProps(dispatch, ownProps) {
  return {
    someCallbackPassedToChildren: () => someThunkMethod())
  };
}

const ConnectedComponent = connect(
    mapStateToProps,
    mapDispatchToProps
)(Component);


