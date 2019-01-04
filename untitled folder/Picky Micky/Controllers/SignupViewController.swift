//
//  SignupViewController.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 10/13/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import UIKit

class SignupViewController: UIViewController,UsersDataSourceDelegate {
    var UsersArray : [User] = []
    let UsersViewdDataSource = UsersDataSource()
    override func viewDidLoad() {
        super.viewDidLoad()
        self.UsersViewdDataSource.delegate = self
        // Do any additional setup after loading the view.
    }
    override func viewWillAppear(_ animated: Bool) {
        self.UsersViewdDataSource.loadUsersList()
    }
    func UsersListLoaded(UserList: [User]) {
        self.UsersArray = UserList}
    
    
    func PostInDatabase(postParameters : String, URL_TO_SAVE : URL){
        
        
        //creating NSMutableURLRequest
        var request = URLRequest(url: URL_TO_SAVE)
        //setting the method to post
        request.httpMethod = "POST"
        //adding the parameters to request body
        request.httpBody = postParameters.data(using: String.Encoding.utf8)
        //creating a task to send the post request
        let task = URLSession.shared.dataTask(with: request as URLRequest){
            data, response, error in
            
            if error != nil{
                print("error is \(error)")
                return;
            }
            //parsing the response
            do {
                if let data = data
                {
                    do
                    {
                        print( String(data: data, encoding: .utf8) )
                    } catch{
                        
                    }
                }
                //converting resonse to NSDictionary
                let myJSON =  try JSONSerialization.jsonObject(with: data!, options: JSONSerialization.ReadingOptions.allowFragments ) as? NSDictionary
            
                //parsing the json
                if let parseJSON = myJSON {
                    
                    //creating a string
                    var msg : String!
                
                    //getting the json response
                    msg = parseJSON["message"] as! String?
                    
                    //printing the response
                    print(msg)
                }
            } catch {
                print(error)
            }
            
        }
        //executing the task
        task.resume()
    }
    
    //Initializing the variables
    

    @IBOutlet weak var Username: UITextField!
    
    @IBOutlet weak var Password: UITextField!
    @IBOutlet weak var Email: UITextField!
    
    
   
    @IBAction func Submit(_ sender: Any) {
        //API link
        let URL_SAVE_TEAM = URL(string: "http://localhost:8888/MyWebServices/api/createteam.php")
        
        //getting values from text fields
        let UserNameText  = Username.text
        let PasswordText  = Password.text
        let EmailText     = Email.text
        
        
        
        //creating the post parameter by concatenating the keys and values from text field
        let postParameters = "Username="+UserNameText!+"&Password="+PasswordText!+"&Email="+EmailText!;
        
        PostInDatabase(postParameters: postParameters,URL_TO_SAVE: URL_SAVE_TEAM!)
    }
    

}
