import $ from 'jquery';

class Like {
  constructor(){
    this.events();
  }

  events(){
    $('.like-box').on('click', this.ourClickDispatcher.bind(this));
  }

  ourClickDispatcher(e){
    let currentLikeBox = $(e.target).closest(".like-box");
    // currentLikeBox.data('exists') の書き方だとページの読み込み時しか効かない
    // リアルタイムのデータの更新なら attr を使う。
    if(currentLikeBox.attr('data-exists') == 'yes') {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(likeBox){
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce); // リクエストヘッダーに once を渡して認可
      },
      url: universityData.root_url + '/wp-json/univ/v1/manageLike/',
      type: 'POST',
      data: {
        'professorId': likeBox.data('professor-id'),
      },
      success: (response) => {
        console.log(response);

        likeBox.attr('data-exists', 'yes');
        let $likeCount = likeBox.find('.like-count')
        let likeCountValue = parseInt($likeCount.text());
        $likeCount.text(likeCountValue + 1);
      },
      error: (response) => {
        console.log(response);
      }
    });
  }
  
  deleteLike(likeBox){
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce); // リクエストヘッダーに once を渡して認可
      },
      url: universityData.root_url + '/wp-json/univ/v1/manageLike/',
      type: 'DELETE',
      data: {
        'professorId': likeBox.data('professor-id'),
      },
      success: (response) => {
        console.log(response);

        likeBox.attr('data-exists', 'no');
        let $likeCount = likeBox.find('.like-count')
        let likeCountValue = parseInt($likeCount.text());
        $likeCount.text(likeCountValue - 1);
      },
      error: (response) => {
        console.log(response);
      }
    });
    
  }

}

export default Like