//
//  AfterLoginOneViewController.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 11/11/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import UIKit

class AfterLoginOneViewController: UIViewController {
    var UsersArray : [User] = []
    var UserName : String! = ""
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
    }
    func UpdateInDatabase(postParameters : String, URL_TO_SAVE : URL){
        
        
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
            print(request
            )
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
    @IBOutlet weak var Followes: UITextField!
    
    @IBOutlet weak var Following: UITextField!
    
    @IBOutlet weak var NumOfPosts: UITextField!
    
    @IBOutlet weak var Famous: UISegmentedControl!
    //function to upload and update the data
    @IBAction func UpdateInfoUser(_ sender: Any) {
        
        let URL_UPDATE_USER = URL(string: "http://localhost:8888/MyWebServices/api/UpdateUser.php")
        let FollowersText  = Followes.text
        let FollowingText  = Following.text
        let NumOfPostsText     = NumOfPosts.text
        let famousText = String(Famous.selectedSegmentIndex)
        if (FollowersText == "" || FollowingText == "" || NumOfPostsText == "" )  {
            print("enter Data first ")
            return
        }
        //creating the post parameter by concatenating the keys and values from text field
        let updateParameters = "FollowingNumber="+FollowersText!+"&FollowersNumber="+FollowingText!+"&NumberOfPosts="+NumOfPostsText!+"&Celebrity="+famousText+"&Username="+UserName;
        print(updateParameters)
        UpdateInDatabase(postParameters: updateParameters,URL_TO_SAVE: URL_UPDATE_USER!)
        /* Create the transition to the correct view controller */
        
        let storyBoard = UIStoryboard(name: "Main" , bundle: nil)
        let MainViewController = storyBoard.instantiateViewController(withIdentifier:"MainView")as! MainViewController
        MainViewController.UserName = self.UserName
        self.present(MainViewController, animated:true, completion:nil)
        
    }
}
