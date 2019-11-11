const
  dateNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
  monthNames = {
    short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    long: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  };

module.exports = class HelperShared{
  static formatDate(time){
    const
      dateObj = new Date(time),
      date = dateObj.getDay(),
      day = dateObj.getDate(),
      dayLast = day[day.len-1],
      dayExt = dayLast === '1' ? 'st' : dayLast === '2' ? 'nd' : dayLast === '3' ? 'rd' : 'th',
      monthIndex = dateObj.getMonth(),
      year = dateObj.getFullYear();
    return {
      dateObj,
      extended: `${dateNames[date]}, ${monthNames.short[monthIndex]} ${day}${dayExt}, ${year}`,
      readable: `${day} ${monthNames.long[monthIndex]} ${year}`,
      code: `${year}-${monthIndex+1}-${day}`,
    };
  }

  static syntax(raw){
    const coverLink = raw.content.jetpack_featured_media_url;

    return {
      id: raw.id,
      title: raw.title.rendered,
      author: 'author', // need author meta support
      section: raw.categories[0],
      summary: raw.excerpt.rendered,
      content: raw.content.rendered,
      coverImage: {
        exists: coverLink !== null,
        link: coverLink,
        caption: '',
      },
      published: this.formatDate(raw.date),
    };
  }
};
