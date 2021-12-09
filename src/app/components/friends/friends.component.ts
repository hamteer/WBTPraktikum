import { Component, ComponentFactoryResolver, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';
import { IntervalService } from 'src/app/services/interval.service';
import { User } from 'src/app/models/User';
import { Friend } from 'src/app/models/Friend';

@Component({
    selector: 'app-friends',
    templateUrl: './friends.component.html',
    styleUrls: ['./friends.component.css']
})
export class FriendsComponent implements OnInit {
    currentUser: User = new User;
    friendUser: Friend = new Friend("", "", 0);
    username: string = "";
    friendArray: Friend[] = [];
    requests: Friend[] = [];
    requestUsername: string = ""; 

    public constructor(private backendService: BackendService, private intervalService: IntervalService, private router: Router) {
    }

    public ngOnInit(): void {
        // load current user
        this.backendService.loadCurrentUser()
            .then((user) => {
                if (user == null) {
                    console.log("User konnte nicht abgerufen werden!");
                } else {
                    console.log("Aktuellen User abgerufen");
                    this.currentUser = user;
                }
            })

        // load friends and requests
        this.loadFriendsAndRequests();

        // start repeated checking of friends, unread messages and requests
        this.intervalService.setInterval("FriendsComponent", () => this.friendsAndRequestsCheck());

        // fill user search datalist with all existing users - TODO!
        
        
    }    

    public loadFriendsAndRequests() {
        // load friend array of current user
        this.backendService.loadFriends()
            .then((loadedFriendsArray) => {
                //console.log(loadedFriendsArray);
                for (let f of loadedFriendsArray) {
                    if(f.status == 'accepted' ) {        // check: friend is accepted
                        f.unreadMessages = 0;
                        this.friendArray.push(f);
                    } else {
                        this.requests.push(f)
                    }
                }
            })

        // load unread messages for friends
        this.backendService.unreadMessageCounts()
            .then((unreadMsgMap) => {
                for(let f of this.friendArray) {
                    let x : number | undefined = unreadMsgMap.get(f.username);
                    if (typeof(x) != 'undefined') {
                        f.unreadMessages = x;
                    }
                }
            })
        
        //console.log(this.friendArray);
        //console.log(this.requests);
    }

    public friendsAndRequestsCheck() {
        // has anything changed? if yes, reload friends and requests!
        this.backendService.loadFriends()
            .then((loadedFriendsArray) => {
                if (loadedFriendsArray.length == this.friendArray.length + this.requests.length) {
                    for(let f = 0; f < this.friendArray.length; f++) {
                        if (loadedFriendsArray[f].username != this.friendArray[f].username) {
                            this.loadFriendsAndRequests();
                        }
                    } 
                    console.log("no changes in friends and/or requests recognized.");
                }
            })
    }

    public acceptFriend(username: string) {
        this.backendService.acceptFriendRequest(username);  // TODO!
    }

    public dismissFriend(username: string) {
        this.backendService.dismissFriendRequest(username); // TODO!
    }

    public sendFriendRequest() {
        this.backendService.friendRequest(this.requestUsername) // TODO!
    }



    // TODO:
    //  - fill Datalist with existing users from server ( --> how to get all users?? <-- )
    //  - get friendRequest username from HTML
    // einmal laden und dann nur prüfen, ob änderungen aufgetreten -> hat das funktioniert?

    // --> testen!!!

}
