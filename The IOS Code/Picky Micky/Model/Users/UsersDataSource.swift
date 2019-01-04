//
//  UsersDataSource.swift
//  Picky Micky
//
//  Created by Mohamed Alhajar on 10/14/18.
//  Copyright © 2018 Mohamed Alhajar. All rights reserved.
//

import Foundation
protocol UsersDataSourceDelegate {
    func UsersListLoaded(UserList : [User])
    func UsersDetailLoaded(UserDetail : User)
}

extension UsersDataSourceDelegate{
    func UsersListLoaded(UserList : [User]) {}
    func UsersDetailLoaded(UserDetail : User) {}
}
class UsersDataSource {
    var delegate : UsersDataSourceDelegate?
    func loadUsersList() {
        let session = URLSession.shared
        var request =  URL(string : "http://localhost:8888/MyWebServices/api/getUser.php")!
       
        //setting the method to post
    
        let dataTask = session.dataTask(with: request) { (data, response, error) in
            let decoder = JSONDecoder()
            if let data = data {
                let json = try! JSONSerialization.jsonObject(with: data, options: [])
                let UsersArray = try! decoder.decode([User].self, from:data)
                self.delegate?.UsersListLoaded(UserList: UsersArray)

                print(UsersArray)}
            if let response = response {
                    print(response)
            }
        }
        dataTask.resume()
    }
   
}
