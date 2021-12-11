import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/User';
import { BackendService } from 'src/app/services/backend.service';
import { RouteConfigLoadEnd, Router } from '@angular/router';
import { Profile } from 'src/app/models/Profile';



@Component({
    selector: 'app-settings',
    templateUrl: './settings.component.html',
    styleUrls: ['./settings.component.css']
})

export class SettingsComponent implements OnInit {
    
    public user!: User | null;
    public userName!: string;

    public profile: Profile = new Profile("firstName", "lastName", '2', "Type in your Description...", "oneliner");

    public username!: string;
    public password!: string;
    public message!: string;

    public constructor(private backendService: BackendService, private router: Router) {
        
    }

    public ngOnInit(): void {
        this.loadUser();
        
    }

    public loadUser() {
        this.backendService.loadCurrentUser()
            .then((user: any) => {
                if (user == null) {
                    console.log('user is null, something failed')
                    this.router.navigate(['/login']);
                } else {
                    this.userName = user.userName;
                    console.log(user);
                    this.profile.firstName = user.firstName ? user.firstName : 'firstName';
                    this.profile.lastName = user.lastName ? user.lastName : 'lastName';
                    this.profile.description = user.description ? user.description : 'Type in your Description...';
                    this.profile.coffeeOrTea = user.coffeeOrTea ? user.coffeeOrTea : 1;
                    this.profile.layout = user.layout ? user.layout : 'oneliner';
                    console.log(this.profile)

                }
            });
    }

    public saveProfile() {
        this.backendService.saveCurrentUserProfile(this.profile)
            .then((ok: boolean) => {
                if(ok) {
                    console.log('Profile has been saved successfully')
                    //this.loadUser()
                    //console.log(this.user)
                } else {
                    console.log('Saving Profile has been failed')
                }
                this.router.navigate(['/friends']);
            });      
    }


    public goBack() {
        this.router.navigate(['/friends']);
    }  

}

