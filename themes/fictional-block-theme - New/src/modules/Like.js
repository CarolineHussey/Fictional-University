import $ from "jquery";

class Like {
  constructor() {
    if (document.querySelector(".like-box")) {
      this.events();
    }
  }

  events() {
    $(".like-box").on("click", this.clickDispatcher.bind(this));
  }

  //methods

  clickDispatcher(e) {
    var currentLikeBox = $(e.target).closest(".like-box");
    if (currentLikeBox.attr("data-exists") === "yes") {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      data: { professorId: currentLikeBox.data("professor") },
      type: "POST",
      success: (response) => {
        currentLikeBox.attr("data-exists", "yes");
        var currentLikeCount = parseInt(
          currentLikeBox.find(".like-count").html(),
          10
        );
        currentLikeCount++;
        currentLikeBox.attr("data-like", response);
        currentLikeBox.find(".like-count").html(currentLikeCount);
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      data: {
        like: currentLikeBox.attr("data-like"),
      },
      type: "DELETE",
      success: (response) => {
        currentLikeBox.attr("data-exists", "no");
        var currentLikeCount = parseInt(
          currentLikeBox.find(".like-count").html(),
          10
        );
        currentLikeCount--;
        currentLikeBox.attr("data-like", "");
        currentLikeBox.find(".like-count").html(currentLikeCount);
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
