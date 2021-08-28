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
    if(currentLikeBox.data('exists') == 'yes') {
      this.deleteLike(currentLikeBox);
      currentLikeBox.data('exists', 'no');
    } else {
      this.createLike(currentLikeBox);
      currentLikeBox.data('exists', 'yes');
    }
  }

  createLike(likeBox){
    console.log('create: ' + likeBox.data('professor-id'));
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
        console.log('作成成功');
      },
      error: (response) => {
        console.log(response);
        console.log('作成失敗');
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
        console.log('削除成功');
      },
      error: (response) => {
        console.log(response);
        console.log('削除失敗');
      }
    });
    
  }

}

export default Like