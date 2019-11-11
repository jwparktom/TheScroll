const
  env = require('../../../universal/env'),
  HelperShared = require('./shared'),
  WPAPI = require('wpapi');

module.exports = class Article extends HelperShared{
  static find(articleId){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        if (!(/^\d+$/.test(articleId))){
          response.error = 'invalid-id-syntax';
          response.status = 'error';
          resolve(response);
        } else {
          const wp = new WPAPI({
            endpoint: env.wp.endpoint,
            username: env.wp.user,
            password: env.wp.pass,
            auth: true,
          });
          wp.posts().id(articleId)
            .then(article => {
              console.log(article);
              const
                cleaned = this.syntax(article),
                related = article['jetpack-related-posts'].map(article => this.syntaxRelated(article));

              cleaned.related = related;
              resolve(cleaned);
            })
            .catch(err => {
              console.log(err);
            });
        }
      } catch (err){
        reject(err);
      }
    });
  }

  static syntaxRelated(raw){
    const
      coverImage = raw.img || {src: ''},
      section = /\“(\w.*?)\”/g.exec(raw.context) || ['', ''];
    return {
      id: raw.id,
      title: raw.title,
      // author: '',
      section: section[1],
      summary: raw.excerpt,
      coverImage: {
        exists: coverImage.src !== null,
        link: coverImage.src,
        caption: '',
      },
      published: this.formatDate(raw.date),
    };
  }
};
