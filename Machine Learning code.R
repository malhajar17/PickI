library(MASS)
library(shiny)
#set.seed(521)
# read data into memory
#data_set <- read.csv("/Users/cdamla/Documents/newdata set - Sheet1.csv")
#label_set <- read.csv("/Users/cdamla/Documents/InstagramLabelSet.csv")

#data_set <- read.csv("/Users/cdamla/Documents/4000_Instagram_tarihli.csv")
#label_set <- read.csv("/Users/cdamla/Documents/4000_likenum.csv")

#data_set <- read.csv("/Users/cdamla/Documents/mixedData.csv")
#label_set <- read.csv("/Users/cdamla/Documents/mixedDataLikeNum.csv")

data_set <- read.csv("/Users/irmak/Desktop/Irmak Tab Pro S/COMP491/9bin_Instagram_edited.csv", header = FALSE)
label_set <- read.csv("/Users/irmak/Desktop/Irmak Tab Pro S/COMP491/9bin_likenum.csv",header = FALSE)

train_data_set <-data_set[1:8110, ]
test_data_set <-data_set[8111:9100, ]

train_label_set <-label_set[1:8110, ]
test_label_set <-label_set[8111:9100, ]

X <- data.matrix(train_data_set)
#X <- X/1000000
X2 <- data.matrix(test_data_set)
#labelMatrix <- data.matrix(label_set)
relu <- function(x)
  ifelse(x >= 0, x, 0)
cf_DFinf2NA <- function(x)
{
  for (i in 1:ncol(x)){
    x[,i][is.infinite(x[,i])] = 0
  }
  return(x)
}

safelog <- function(x) {
  return (cf_DFinf2NA(log(x + 1e-100)))
}

sigmoid <- function(a) {
  return (1 / (1 + exp(-a)))
}
eta <- 5e11 #0.00000000005 #0.000000000005
epsilon <-0.01 #1e-3
H <- 30 #20
max_iteration <- 500
set.seed(521)

W <- matrix(runif((30) * H, min = -0.1, max = 0.1),30, H)
v <- matrix(runif((1) * H, min = -12, max = 3), 1, H) #v <- matrix(runif((1) * H, min = -1, max = 5), 1, H)

Z <- sigmoid(X %*% W)>
  Y_predicted <- Z%*%t(v)
objective_values <- -sum( train_label_set * (safelog(Y_predicted)))
#+ (1 - Y_truth) * safelog(1 - y_predicted))

iteration <- 1
while (1) {
  for (i in sample(8110)) {
    # calculate hidden nodes
    Z[i,] <- sigmoid(X[i,] %*% W)
    # calculate output node
    Y_predicted[i,] <- Z[i,] %*% t(v)
    
    v <- relu(v + eta * (train_label_set[i] - Y_predicted[i]) %*% t(Z[i,]))
    for (h in 1:H) {
      W[,h] <- relu(W[,h] + eta * sum((train_label_set[i] - Y_predicted[i]) * v[,h]) * Z[i, h] * (1 - Z[i, h]) %*% X[i,])
    }
    
  }
  
  Z <- sigmoid( X %*% W)
  Y_predicted <- Z%*%t(v)
  objective_values <- c(objective_values, -sum(train_label_set * (safelog(Y_predicted))))
  #+ (1 - Y_truth) * safelog(1 - y_predicted)))
  
  if (abs(objective_values[iteration + 1] - objective_values[iteration]) < epsilon |iteration >= max_iteration) {
    break
  }
  iteration <- iteration + 1
}

plot(1:(iteration+1) , objective_values,
     type = "l", lwd = 2, las = 1,
     xlab = "Iteration", ylab = "Error"
)

#X2 %*% W %*% t(v) 
#sigmoid(X2 %*% W) %*% t(v)

#linear regression kodu: 
#summary(lm(train_label_set~., data = train_data_set))
