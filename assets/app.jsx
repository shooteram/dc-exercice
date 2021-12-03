/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import React from 'react';
import ReactDOM from 'react-dom';
import {
    HashRouter as Router,
    Routes,
    Route,
} from 'react-router-dom';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Home from './components/Home';
import Article from './components/Article';

ReactDOM.render(
    <Router>
        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/article/:id" element={<Article />} />
        </Routes>
    </Router>,
    document.getElementById('root'),
);
