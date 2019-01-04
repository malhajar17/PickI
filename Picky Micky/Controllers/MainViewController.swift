//
//  MainViewController.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 11/12/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import UIKit
//import Alamofire

class MainViewController: UIViewController,UIImagePickerControllerDelegate,UINavigationControllerDelegate {
   
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
    }
    var UsersArray : [User] = []
    let Ranges : [String] =
        [
            " 0-15",
            "15-30",
            "30-45",
            "45-60",
            "60-90",
            "90-120",
            "120-180",
            "180-300",
            "300-420",
            "420-540",
            "540-660",
            "660-900",
            "900-1140",
            "1140-1620",
            "1620-2580",
            "2580-3540",
            "3540-4500",
            "4500-6500",
            "6500-9500",
            "9500-13500",
            "13500-18500",
            "18500-24500",
            "24500-31500",
            "31500-39500",
            "39500-48500",
            "48500-58500",
            "58500-69500",
            "69500-81500",
            "81500-100000",
            "1000000"
    ]
    var userlikesRange: Int = 0
    var UserName : String! = ""
    struct Likes: Codable {
        var LikeNumber: Int
    }

    @IBOutlet weak var ImageShow: UIImageView!
    
    @IBAction func ChooseImage(_ sender: UIButton) {
        let ImagePickerController = UIImagePickerController()
        ImagePickerController.delegate=self
        let actionSheet = UIAlertController(title: "Photo Source", message: "Choose a source", preferredStyle: .actionSheet)
        actionSheet.addAction(UIAlertAction(title: "Camera", style: .default, handler: { (action:UIAlertAction) in ImagePickerController.sourceType = .camera
            self.present(ImagePickerController,animated: true,completion: nil)
        }))
        actionSheet.addAction(UIAlertAction(title: "Photo Library", style: .default, handler: { (action:UIAlertAction) in ImagePickerController.sourceType = .photoLibrary
            self.present(ImagePickerController,animated: true,completion: nil)
            
        }))
        actionSheet.addAction(UIAlertAction(title: "Cancel", style: .default, handler: { (action:UIAlertAction) in
            
        }))
        self.present(actionSheet, animated: true,completion: nil)
        
    }
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [UIImagePickerController.InfoKey : Any]) {
    let image = info[UIImagePickerController.InfoKey.originalImage] as! UIImage
        ImageShow.image = image
   
        myImageUploadRequest()
        
        picker.dismiss(animated: true, completion: nil)
       
        
    }
    func imagePickerControllerDidCancel(_ picker: UIImagePickerController) {
        picker.dismiss(animated: true, completion: nil)
    }
    let storyBoard = UIStoryboard(name: "Main" , bundle: nil)
    @IBAction func Logout(_ sender: Any) {
        let Logout = storyBoard.instantiateViewController(withIdentifier:"Login")as! ViewController
        self.present(Logout, animated:true, completion:nil)
    }
    //Internet Code
    func myImageUploadRequest()
    {
        
        let myUrl = NSURL(string: "http://localhost:8888/MyWebServices/api/UploadImage.php");
        //let myUrl = NSURL(string: "http://www.boredwear.com/utils/postImage.php");
//      /UploadImage
        let request = NSMutableURLRequest(url:myUrl! as URL);
        request.httpMethod = "POST";
        
        let param = [
            "username"  : UserName!
        ]
        
        let boundary = generateBoundaryString()
        
        request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
        
        
        let imageData = ImageShow.image!.jpegData(compressionQuality: 0.75)

//            UIImageJPEGRepresentation(ImageShow.image!, 1)
        
        if(imageData==nil)  { return; }
        
        request.httpBody = createBodyWithParameters(parameters: param, filePathKey: "file", imageDataKey: imageData! as NSData, boundary: boundary) as Data
        
        
//        UIActivityIndicatorView.startAnimating();
        
        let task = URLSession.shared.dataTask(with: request as URLRequest) {
            data, response, error in
            
            if error != nil {
                print("error=\(error)")
                return
            }
            
            // You can print out response object
//            print("******* response = \(response)")
            
            // Print out reponse body
            let responseString = NSString(data: data!, encoding: String.Encoding.utf8.rawValue)
            print("****** response data = \(responseString!)")
            
            do {
                 let decoder = JSONDecoder()
                let json = try JSONSerialization.jsonObject(with: data!, options: [])
                print(data)
                let UserLikes = try! decoder.decode(Likes.self, from:data!)
                self.userlikesRange = UserLikes.LikeNumber
                print(self.userlikesRange)
                let alert = UIAlertController(title: "You will Get!", message:self.Ranges[self.userlikesRange-1] , preferredStyle: .alert)
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
            //
                //print(UserLikes)
              
                
//                dispatch_async(dispatch_get_main_queue(),{
//                    self.myActivityIndicator.stopAnimating()
//                    self.myImageView.image = nil;
//                });
                
            }catch
            {
                print(error)
            }
            
        }
        
        task.resume()
    }
    
    
    func createBodyWithParameters(parameters: [String: String]?, filePathKey: String?, imageDataKey: NSData, boundary: String) -> NSData {
        let body = NSMutableData();
        
        if parameters != nil {
            for (key, value) in parameters! {
                body.appendString(string: "--\(boundary)\r\n")
                body.appendString(string: "Content-Disposition: form-data; name=\"\(key)\"\r\n\r\n")
                body.appendString(string:"\(value)\r\n")
            }
        }
        
        let filename = UserName! + ".jpg"
        let mimetype = "image/jpg"
        
        body.appendString(string: "--\(boundary)\r\n")
        body.appendString(string: "Content-Disposition: form-data; name=\"\(filePathKey!)\"; filename=\"\(filename)\"\r\n")
        body.appendString(string: "Content-Type: \(mimetype)\r\n\r\n")
        body.append(imageDataKey as Data)
        body.appendString(string: "\r\n")
        
        
        
        body.appendString(string: "--\(boundary)--\r\n")
        
        return body
    }
    
    
    
    func generateBoundaryString() -> String {
        return "Boundary-\(NSUUID().uuidString)"
    }
    
    
}
extension NSMutableData {
    
    func appendString(string: String) {
        let data = string.data(using: String.Encoding.utf8, allowLossyConversion: true)
        append(data!)
    }
}
        

