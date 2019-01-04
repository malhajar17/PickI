//
//  ViewController.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 10/13/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import UIKit

class ViewController: UIViewController,UsersDataSourceDelegate,UITextFieldDelegate {
    var UsersArray : [User] = []
    let UsersViewdDataSource = UsersDataSource()
   //Variables to declare
    @IBOutlet weak var UsernameText: UITextField!
    @IBOutlet weak var PasswordText: UITextField!
    
    override func viewDidLoad() {
        self.UsersViewdDataSource.delegate = self
        super.viewDidLoad()
        self.UsernameText.delegate = self as! UITextFieldDelegate
        self.PasswordText.delegate = self as! UITextFieldDelegate
      
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        self.view.endEditing(true)
        return false
    }
    override func viewWillAppear(_ animated: Bool) {
        self.UsersViewdDataSource.loadUsersList()
    }
    func UsersListLoaded(UserList: [User]) {
        self.UsersArray = UserList
        print(UsersArray)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
//Login Function
    @IBAction func Login(_ sender: Any)
    {
        let storyBoard = UIStoryboard(name: "Main" , bundle: nil)
        print(UsersArray)
        // First Function Searches for the occurnece of the username and password and checks if its true
        if(SearchInUser(UserName: UsernameText?.text, Password: PasswordText?.text) == 2)
        {
            //Case : The user and the password are correct and its his first time
            
            /* Create the transition to the correct view controller */
            
            
            let AfterLoginOne = storyBoard.instantiateViewController(withIdentifier:"AfterLoginOne")as! AfterLoginOneViewController
            
            // Setting the Variables of the new view controller
            
            AfterLoginOne.UsersArray = UsersArray
            AfterLoginOne.UserName = SearchInUserReturnUser(UserName: UsernameText?.text).Username
            
            self.present(AfterLoginOne, animated:true, completion:nil)
            
            /* End of First Transition to view controller  */
        }
        if(SearchInUser(UserName: UsernameText?.text, Password: PasswordText?.text) == 0)
        {
            let alert = UIAlertController(title: "Error", message:"Wrong Username or password" , preferredStyle: .alert)
            alert.addAction(UIAlertAction(title: "OK", style: .default, handler: { action in
                switch action.style{
                case .default:
                    print("default")
                    
                case .cancel:
                    print("cancel")
                    
                case .destructive:
                    print("destructive")
                    
                    
                }}))
             self.present(alert, animated: true, completion: nil)
        }
        else {
             let AfterLoginTwo = storyBoard.instantiateViewController(withIdentifier:"MainView")as! MainViewController
            AfterLoginTwo.UsersArray = UsersArray
            AfterLoginTwo.UserName = UsernameText.text
             self.present(AfterLoginTwo, animated:true, completion:nil)
        }
        
    }
    //Function to check if the username and password and Did login are existing
    func  SearchInUser(UserName:String? , Password:String?)->Int
    {
        for user in UsersArray {
            print(user)
            if(user.Username == UserName)
            {
                if(user.Password == Password)
                {
                    if(user.DidLogin == "1")
                    {
                        return 1
                    }
                    else
                    {
                        return 2
                    }
                }
                
            }
        }
        return 0
    }
    
    func  SearchInUserReturnUser(UserName:String?)->User
    {
        let EmptyUser = User(Email: "-1", FirstName: "-1",ID: "-1", LastName: "-1",Username: "-1", Password: "-1",FollowingNumber: "-1", FollowersNumber: "-1",NumberOfPosts: "-1", Celebrity: "-1",DidLogin : "-1")
        
        for user in UsersArray {
            if(user.Username == UserName)
            {
                return user
            }
        }
        return EmptyUser
    }

}

