import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';


import HomePage from './views/Home';
import './style/main.scss'
import globalStyle from './style/globals.module.css'
import { getPosts, getWeather } from './api/api'

class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            posts: [],
            items: ''
        };
    }

    async componentDidMount() {
        await getPosts()
            .then(data => {
                    this.setState({
                        posts: data.data,
                    });
                    //console.log(data.data);
                },
                // Note: it's important to handle errors here
                // instead of a catch() block so that we don't swallow
                // exceptions from actual bugs in components.
                (error) => {
                    this.setState({
                        error
                    });
                }
            );


        // Get the local temperature
        await getWeather()
            .then(
                (result) => {
                    this.setState({
                        items: result.data?.current
                    });
                },
                // Note: it's important to handle errors here
                // instead of a catch() block so that we don't swallow
                // exceptions from actual bugs in components.
                (error) => {
                    this.setState({
                        error
                    });
                }
            )

        this.setState({
            isLoaded: true,
        });
    }

    render() {
        const { error, isLoaded, posts, items } = this.state;

        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        } else {

            return (
                <>
                    <HomePage posts={posts} temperature={items?.temp_c}/>
                </>
            );
        }
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App className={globalStyle.app}/>, document.getElementById('app'));
}
