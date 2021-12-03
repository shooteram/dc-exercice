import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const Home = () => {
    const [articles, setArticles] = useState([]);
    const [error, setError] = useState('');

    const fetchArticles = async () => {
        await fetch('/api/news')
            .then(response => response.json())
            .then(data => { setArticles(data['hydra:member']) })
            .catch(error => { setError(error.message) });
    }

    useEffect(async () => { await fetchArticles() }, []);

    return <>
        {error && <p style={{color: 'red'}}>{error}</p>}

        <h1>Articles</h1>
        <ul>
            {articles.map(article =>
                <li key={article.id}>
                    <Link to={`/article/${article.id}`}>
                        {article.title}
                    </Link>
                </li>
            )}
        </ul>
    </>;
}

export default Home;
