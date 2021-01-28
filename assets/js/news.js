'use strict';

var renderNews = function(news, options) {
    var template = document.querySelector('[data-news-template]');

    if(!template) {
        return;
    }

    var container = template.parentElement;
    container.innerHTML = '';

    for(var i = 0; i < Math.min(news.length, (options ? options.amount : 3)); i++) {
        var article = news[i];
        var articleEl = template.cloneNode(true);

        var titleEl = articleEl.querySelector('[data-news-template-title]'),
            linkEl = articleEl.querySelector('[data-news-template-link]'),
            dateEl = articleEl.querySelector('[data-news-template-date]');

        if(titleEl) {
            titleEl.innerText = article['title']
        }

        if(linkEl) {
            linkEl.setAttribute('href', article['link']);
        }

        if(dateEl) {
            var date = new Date(article['date']);

            if(date instanceof Date && !isNaN(date.getTime())) {
                dateEl.innerHTML = __('month_' + date.getMonth()) + ' ' +
                    (date.getDate() > 10 ? date.getDate() : '0' + date.getDate());
            }
        }

        container.appendChild(articleEl);
    }
};