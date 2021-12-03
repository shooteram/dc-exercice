import React, { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";

const Article = () => {
    const [article, setArticle] = useState({});
    const [error, setError] = useState('');

    let { id } = useParams();

    const fetchArticle = async () => {
        await fetch('/api/news/' + id)
            .then(response => response.json())
            .then(data => { setArticle(data) })
            .catch(error => { setError(error.message) });
    }

    useEffect(async () => { await fetchArticle() }, []);

    return <>
        {error && <p style={{color: 'red'}}>{error}</p>}

        <Link to="/">back</Link>
        <h1>
            {article.url ?
                <a target={'_blank'} href={article.url}>{article.title}</a>
                : article.title}
        </h1>

        <p>{article.description}</p>
        <img src={article.image} alt={article.title} />
        <p>{article.content}</p>
    </>;
}

export default Article;
