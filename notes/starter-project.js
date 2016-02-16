1.  install virtualbox
    https://www.virtualbox.org/wiki/Downloads

2.  install vagrant
    http://www.vagrantup.com/downloads.html

3.  add the laravel/homestead box to your Vagrant installation
    vagrant box add laravel/homestead

4.  clone the homestead repo into Homestead folder within "home" directory
    git clone https://github.com/laravel/homestead.git Homestead

5.  create homestead.yaml
    bash init.sh
    will be placed in '~/.homestead'

6.  configure homestead
    ip: "192.168.10.10"
    provider: virtualbox
    authorize: ~/richard_homestead.pub
    keys:
        - ~/richard_homestead
    folders:
        - map: ~/Dropbox/dev/code
        to: /home/vagrant/code
    sites:
        - map: reserveadock.dev
          to: /home/vagrant/code/reserveadock/public

7.  update hosts file
    C:\Windows\System32\drivers\etc\hosts
    192.168.10.10  reserveadock.dev

8.  launch box
    from ~./Homestead run vagrant up
    from anywhere: homesdtead up

9.  ssh into box
    use putty
    127.0.0.1:2222
    private key at ~\.homestead\.vagrant\machines\default\virtualbox

10. MySQL access via phpmyadmin
    http://localhost:8000/
    username: homestead
    password: secret

11. MySQL access via Navicat
    127.0.0.1:33060
    username: homestead
    password:secret

12. install laravel
    composer global require "laravel/installer"
    laravel new <name>

13. configure laravel
    database.php
    .env file
    app.php

14. run npm init

15. install dependencies

    npm install --save bootstrap@4.0.0-alpha.2
    npm install --save classnames
    npm install --save immutable
    npm install --save jquery
    npm install --save react
    npm install --save react-dom
    npm install --save react-motion
    npm install --save react-redux
    npm install --save react-router@1.0.0-rc3
    npm install --save redux
    npm install --save redux-thunk
    npm install --save axios

    // npm install --save socket.io
    // npm install --save socket.io-client
    // npm install --save react-treeview

    npm install --save-dev autoprefixer
    npm install --save-dev babel-core
    npm install --save-dev babel-loader
    npm install --save-dev babel-plugin-react-autoprefix
    npm install --save-dev babel-preset-es2015
    npm install --save-dev babel-preset-react
    npm install --save-dev babel-preset-stage-2
    npm install --save-dev chai
    npm install --save-dev chai-immutable
    npm install --save-dev css-loader
    npm install --save-dev file-loader
    npm install --save-dev jsdom@3
    npm install --save-dev mocha
    npm install --save-dev node-sass
    npm install --save-dev postcss-loader
    npm install --save-dev react-addons-test-utils
    npm install --save-dev react-hot-loader
    npm install --save-dev redux-devtools
    npm install --save-dev sass-loader
    npm install --save-dev style-loader
    npm install --save-dev url-loader
    npm install --save-dev webpack
    npm install --save-dev webpack-dev-server



15b. babel.rc
    {
      "presets": ["react", "stage-2", "es2015"],
      "plugins": ["react-autoprefix"]
    }

16. package.json
    update scripts

17. webpack.config.js

18. modify welcome.php

19. src/index.js

20. src/reducer.js

21. src/components/App.js

22. src/action_creators.js

23. smart components

24. dumb components


//= REFERENCE =======================================================================================================================

a.  application state data structure
    design the tree that holds the data

b.  Pure Functions to handle data tree

    // all iterables
    butLast()
    concat( [] )
    countBy( (value, key ) => G )
    entries()
    equals(other)
    every( (value, key ) => boolean )
    filter( (value) => { return boolean })
    find( (value, key ) => boolean, notSetValue )
    findEntry( (value, key ) => boolean, notSetValue )
    findLast( (value, key ) => boolean, notSetValue )
    findLastEntry( (value, key ) => boolean, notSetValue )
    first()
    flatMap( (value, key ) => {} } )
    flatten(depth):
    get(key, notSetValue)
    getIn([searchKeyPath], notSetValue)
    groupBy( (value, key) => group )
    has(key)
    hasIn([searchKeyPath])
    includes(value)
    isEmpty()
    join(separator)
    keys()
    last()
    map( (value) => { return value })
    max( (valueA, valueB) => number)
    min( (valueA, valueB) => number)
    minBy( (value, key ) => C, (valueA, valueB) => number )
    maxBy( (value, key ) => C, (valueA, valueB) => number )
    reduce( ( value, key  ) => R, initial ): R
    reduceRight( ( value, key  ) => R, initial ): R
    rest()
    reverse()
    size()
    skip(amount)
    skipLast(amount)
    skipUntil( (value, key) => boolean )
    skipWhile( (value, key) => boolean )
    slice(begin, end)
    some( (value, key ) => boolean )
    sort( (valueA, valueB) => number)
    sortBy( (obj) => obj.value,  (valueA, valueB) => number)
    take(amount)
    takeLast(amount)
    takeUntil( (value, key) => boolean )
    takeWhile( (value, key) => boolean )
    toArray()
    toJSON()
    toList()
    toMap()
    toObject()
    values()

    // indexed iterables also have
    splice(index, removeNum )
    indexOf(searchValue: T): number
    lastIndexOf(searchValue: T): number
    findIndex( (value, index ) => boolean )
    findLastIndex( (value, index ) => boolean )

    // create map
    my_map = Map()
    my_map = Map(array)
    my_map = Map({key:value})
    my_map = Map([["key", "value"]])
    my_map = my_object.asImmutable()

    // create list
    my_list = List()
    my_list = List(array)
    my_list = List.of.(array)

    // booleans
    Map.isMap(my_map)
    List.isList(my_list)

    // update map
    my_map.clear()
    my_map.delete(key)
    my_map.deleteIn([keyPath], value)
    my_map.merge({key:value})
    my_map.mergeDeep({key:value})
    my_map.mergeDeepIn([keyPath], {key:value} )
    my_map.mergeDeepWith( (prev_value, new_value) => { return new_value},  new_map )
    my_map.mergeIn([keyPath], {key:value} )
    my_map.mergeWith( (prev_value, new_value) => { return new_value},  new_map )
    my_map.set(key, value)
    my_map.setIn([keyPath], value)
    my_map.update(key, (val_in) => val_out)
    my_map.update(key, notSetValue, (val_in) => val_out);
    my_map.updateIn([keyPath], notSetValue, (val_in) => val_out) )
    my_map.withMutations( map => { map.set(key1, value1).set(key2, value2).set(key3, value3) })

    // update list
    my_list.clear()
    my_list.delete(index)
    my_list.deleteIn([keyPath])
    my_list.pop()
    my_list.push([...])
    my_list.set(index, value)
    my_list.setIn([keyPath], value)
    my_list.setSize(size)
    my_list.shift()
    my_list.unshift([...])
    my_list.update( (old_val) => { return new_value})
    my_list.update(index, notSetValue, (old_val) => { return new_value})
    my_list.updateIn( [keyPath], notSetValue, (old_val) => { return new_value})


c.  Immutable Data Mgmt
    import {List, Map} from 'immutable';
    List
        let my_list = List.of('Trainspotting', '28 Days Later');
        my_list.push(movie);
        my_list.take(<number>);
        my_list.skip(<number>);
        my_list.set(0, 'Sunshine');
    Map
        let my_map = Map({ movies: my_list });
        my_map.set( 'movies', my_map.get('movies').push(movie) );
        my_map.update('movies', (movies) => {movies.push(movie)} );
        my_list = my_map.get('movies');
        my_map.merge({ <key_name>: <new_value> });
        my_map.has(key)


//========================================================================================================================

14. Animation

import {Motion, StaggeredMotion, TransitionMotion, presets, spring, utils} from 'react-motion';

// [stiffness, damping]
noWobble: [170, 26], // the default
gentle: [120, 14],
wobbly: [180, 12],
stiff: [210, 20]

//......................................................................................................

let default_style = {
              param_1: value_start_1,
              param_2: value_start_2
            };

let end_style = {
              param_1: spring(value_end_1, [stiffness_1, damping_1]),
              param_2: spring(value_end_2, [stiffness_2, damping_2])
            };

//......................................................................................................

<Motion key={key} defaultStyle={default_style} style={end_style}>
  {({param_1, param_2 }) =>
    <div
        <other_html_attributes>
        style={{
        otherNonAnimatedAttribute: otherNonAnimatedValue,
        attribute_1: `translate3d(${param_1}px, ${param_2}px, 0) scale(${param_3})`
        }}
    />
  }
</Motion>

//......................................................................................................

<StaggeredMotion
    defaultStyles=  {[
                        {object_param: object_1_start_value},
                        {object_param: object_2_start_value},
                        {object_param: object_3_start_value}
                    ]}
    styles =    {[
                    {object_param: object_1_end_value},
                    {object_param: object_2_end_value},
                    {object_param: object_3_end_value}
                ]}
    >
    { interpolatedStylesArray =>
        <div>
          {interpolatedStylesArray.map((obj, i) =>
            <div key={i} style={{left: obj.object_param}} />
          )}
        </div>
    }
/>

//......................................................................................................

<TransitionMotion />

defaultStyles: ?Object<string, Object>
styles: Object | (?Object -> Object)
children: Object -> ?ReactElement

//========================================================================================================================