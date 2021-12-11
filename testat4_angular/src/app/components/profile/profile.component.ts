import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Profile } from 'src/app/models/Profile';
import { User } from 'src/app/models/User';
import { BackendService } from 'src/app/services/backend.service';
import { ContextService } from 'src/app/services/context.service';


@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
    currentUser: User = new User;
    lookedAtUser: User = new User;
    unknownProfile: unknown;
    lookedAtProfile: Profile = new Profile("", "", "", "", "");
    coffeeOrTea: string = "";

    public constructor(private backendService : BackendService, private router: Router, private context : ContextService) { 
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

        // load user whose profile is looked at
        this.backendService.loadUser(this.context.currentChatUsername)
            .then((user) => {
                if (user == null) {
                    console.log("Chatpartner konnte nicht abgerufen werden");
                } else {
                    console.log("Chatpartner abgerufen");
                    this.lookedAtUser = user;
                    this.unknownProfile = <unknown> user;
                    this.lookedAtProfile = <Profile> this.unknownProfile;
                    
                    switch(Number(this.lookedAtProfile.coffeeOrTea)) {
                        case (1):
                            console.log("case1");
                            this.coffeeOrTea = "Neither nor";
                            break;
                        case (2):
                            console.log("case2");
                            this.coffeeOrTea = "Coffee";
                            break;
                        case (3):
                            console.log("case3");
                            this.coffeeOrTea = "Tea";
                            break;
                        default:
                            break;            
                    }

                }
            })
        
    }

    public removeFriend() {
        if (confirm("Are you sure you want to remove " + this.context.currentChatUsername + " as friend?")) {
            console.log("removing friend ... ")
            this.backendService.removeFriend(this.context.currentChatUsername);
            this.router.navigate(['/friends']);
        }
    }

}
