/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Favorite = function () {
    this.lFavorites = [];
    this.obj = null

    this.linkFavorite = function (o) {
        this.obj = lEventos[o];
        this.addFavorite();
    }

    this.addFavorite = function () {
        //Block from add to favorite without login on facebook
        if (localStorage.getItem("facebook") === null) {
            mapUtils.showMessage('Faça o login com o Facebook para gerenciar seus favoritos!', "#454545");
            return;
        }
        //Log action
        console.log(this);
        if (localStorage.getItem("fav") !== null) {
            this.lFavorites = JSON.parse(localStorage.getItem("fav"));
        }
        for (i = 0; i < this.lFavorites.length; i++) {
            if (JSON.stringify(this.lFavorites[i]) === JSON.stringify(this.obj)) {
                return;//Already exists
            }
        }
        this.saveRemoteFav();
        this.lFavorites.push(this.obj);
        localStorage.setItem("fav", JSON.stringify(this.lFavorites));
        console.log('FAV');
    }
    this.setCurrentF = function (f) {
        this.obj = f;
    }
    this.saveRemoteFav = function () {
        console.log('FAV1');
        var email = localStorage.getItem("email");
        var idEvent = this.obj.idEvent === undefined ? "-1" : this.obj.idEvent;
        var idPlace = this.obj.idPlace === undefined ? null : this.obj.idPlace;
        var url = "https://guiafloripa.morettic.com.br/favorite/";
        var postData = {email: (email), eventID: idEvent, pId: idPlace};
        console.log(postData);
        $.ajax({
            type: 'POST',
            url: url,
            data: postData,
            success: function (data) {
                console.log(data);
                console.log(status);
                mapUtils.showMessage('Adicionado aos favoritos', "#454545");
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
}

var myFavorites = new Favorite();
