//*** setup
npm install -g reapp
reapp new <project_name>
cd <project_name>
reapp run
localhost:3010

// ----------------------------------------------------------------------------------------

import iOSTheme from 'reapp-ui/themes/ios/theme'
import Theme from 'reapp-ui/helpers/Theme';
import Button from 'reapp-ui/components/Button';
import React from 'react';

export default React.createClass({
  render() {
    return (
      <Theme {...iOSTheme}>
        <Button color="red" />
      </Theme>
    );
  }
});

// ----------------------------------------------------------------------------------------

home.jsx
import { Reapp, React, View} from 'reapp-kit';
var Home = React.createClass({
  render: function() {
    return (
        <View title="Where Am I">
            <Child />
        </View>
    );
  }
});
export default Reapp(Home);

// ----------------------------------------------------------------------------------------

app.js
import './theme';
import { router, route } from 'reapp-kit';
router(require,
  route('home', '/')
);

// ----------------------------------------------------------------------------------------

routes.js
module.exports = ({ routes, route }) =>
  routes(require,
    // wire up "/" to the name app, which Reapp’s router willlook for in ./components/App.jsx.
    route('app', '/', { dir: '' })
);

App.jsx
import React from 'react';
import View from 'reapp-ui/views/View';
import Button from 'reapp-ui/components/Button';
import Input from 'reapp-ui/components/Input';
import Gallery from 'reapp-ui/components/Gallery';
const key = '__YOUR_KEY_HERE__';
const base = 'https://api.flickr.com/services/rest/?api_key=${key}&format=rest&format=json&nojsoncallback=1';
export default React.createClass({
    getInitialState() {
        return {
            photos: []
        }
    },
    handleSearch() {},
    render() {
        var { photos } = this.state;
        return (
            <View title="Flickr Search">
                <Input ref="search" classname="img-responsive" />
                <Button onTap={this.handleSearch}>Search Images</Button>
                { // verticalCenter property is given to us by Reapp
                }
                <div className="verticalCenter">
                  {!photos.length &&
                    <p>No photos!</p>
                  }
                </div>
            </View>
        );
    }
});


