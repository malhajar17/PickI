//
//  Users.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 10/13/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import Foundation
struct  User : Codable {
    var Email           : String
    var FirstName       : String
    var ID              : String
    var LastName        : String
    var Username        : String
    var Password        : String
    var FollowingNumber : String
    var FollowersNumber : String
    var NumberOfPosts   : String
    var Celebrity       : String
    var DidLogin        : String
    init(Email: String, FirstName: String,ID: String, LastName: String,Username: String, Password: String,FollowingNumber: String, FollowersNumber: String,NumberOfPosts: String, Celebrity: String,DidLogin : String) {
        self.Email = Email
        self.FirstName = FirstName
        self.ID = ID
        self.LastName = LastName
        self.Username = Username
        self.Password = Password
        self.FollowingNumber = FollowingNumber
        self.FollowersNumber = FollowersNumber
        self.NumberOfPosts = NumberOfPosts
        self.Celebrity = Celebrity
        self.DidLogin = DidLogin
    }
}
