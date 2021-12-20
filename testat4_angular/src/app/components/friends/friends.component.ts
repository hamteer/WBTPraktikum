import { Component, ComponentFactoryResolver, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';
import { IntervalService } from 'src/app/services/interval.service';
import { ContextService } from 'src/app/services/context.service';
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

    // arrays for Friends and friend requests
    loadedFriendsArray: Friend[] = [];
    displayedFriendArray: Friend[] = [];
    displayedRequests: Friend[] = [];

    requestUsername: string = ""; 
    chatUsername : string = "";

    public constructor(private backendService: BackendService, private intervalService: IntervalService, private router: Router, private contextService : ContextService) {
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

        this.setDisplayedArrays();

        // start repeated checking of friends, unread messages and requests
        this.intervalService.setInterval("FriendsComponent", () => this.friendsAndRequestsCheck());
    }    

    public loadFriendsAndRequests() {
        // load friend array of current user and set unread messages to 0
        this.backendService.loadFriends()
            .then((FriendsArray) => {
                //console.log(loadedFriendsArray);
                this.loadedFriendsArray = FriendsArray;
                for (let f of this.loadedFriendsArray) {
                    f.unreadMessages = 0;
                }
            })

        // load unread messages for friends
        this.backendService.unreadMessageCounts()
            .then((unreadMsgMap) => {
                for(let f of this.loadedFriendsArray) {
                    let x : number | undefined = unreadMsgMap.get(f.username);
                    if (typeof(x) != 'undefined') {
                        f.unreadMessages = x;
                    }
                }
            })
        
        //console.log(this.friendArray);
        //console.log(this.requests);
    }

    public setDisplayedArrays() {
        this.displayedFriendArray = [];
        this.displayedRequests = [];
        // set values for displayed arrays
        for (let f of this.loadedFriendsArray) {
            if (f.status == 'accepted') {
                this.displayedFriendArray.push(f);
            } else {
                this.displayedRequests.push(f);
            }
        }
    }

    public friendsAndRequestsCheck() {
        // has anything changed? if yes, reload friends and requests!
        // first, reload friends and messages
        // then, check if array size, usernames and unread messages are unchanged
        //  -> if not, set display values
        this.setDisplayedArrays();

        this.backendService.loadFriends()
            .then((newFriendsArray) => {
                if (newFriendsArray.length == this.loadedFriendsArray.length) {
                    //console.log("no changes in friends and/or requests recognized.");
                } else {
                    this.loadFriendsAndRequests();
                    this.setDisplayedArrays();
                    //console.log("changes in array length detected - arrays overwritten")
                }

                // check if usernames and status are consistent with before
                for (let f = 0; f < newFriendsArray.length; f++) {
                    if (newFriendsArray[f].username != this.loadedFriendsArray[f].username || newFriendsArray[f].status != this.loadedFriendsArray[f].status) {
                        this.loadFriendsAndRequests();
                        this.setDisplayedArrays();
                        //console.log("changes in usernames or status detected - arrays overwritten")
                    }
                }
            })

        // check if new unread messages have arrived
        this.backendService.unreadMessageCounts() 
            .then((loadedMsgMap) => {
                for (let f of this.loadedFriendsArray) {
                    if (f.unreadMessages != loadedMsgMap.get(f.username)) {
                        this.loadFriendsAndRequests();
                        this.setDisplayedArrays();
                        //console.log("changes in unread messages detected - arrays overwritten")
                    }
                }
            })
    }

    public acceptFriend(username: string) {
        this.backendService.acceptFriendRequest(username); 
    }

    public dismissFriend(username: string) {
        this.backendService.dismissFriendRequest(username); 
    }

    public sendFriendRequest() {
        console.log(this.requestUsername);
        this.backendService.userExists(this.requestUsername)
            .then((ok) => {
                if (ok) {
                    console.log("user exists, sending friend request")
                    this.backendService.friendRequest(this.requestUsername);
                } else {
                    console.log("user doesn't exist!")
                }
            })
    }

    public stopLoop() {
        console.log("stopping loop...");
        this.intervalService.clearIntervals();
    }

    public goIntoChat(chatPartnerName : string) {
        this.contextService.currentChatUsername = chatPartnerName;
        console.log("stopping loop...");
        this.intervalService.clearIntervals();
    }
}
