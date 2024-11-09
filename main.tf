#Poner el proveedor de terraform, en este caso aws
terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }
}

# Configurar la region de aws.
provider "aws" {
  region = "us-east-1"
}

# Crear una VPC.
resource "aws_vpc" "Desarrollo-web-VPC" {
  cidr_block = "10.0.0.0/16"
  tags = {
    "Name" = "VPC"
  }
} 

#red pública.
resource "aws_subnet" "subred-publica" {
  vpc_id = aws_vpc.Desarrollo-web-VPC.id
  cidr_block = "10.0.101.0/24"
  map_public_ip_on_launch = true        #necesario para las redes publicas
  tags = {
    "Name" = "subred-publica"
  }
}

#red privada
resource "aws_subnet" "subred-privada" {
  vpc_id = aws_vpc.Desarrollo-web-VPC.id
  cidr_block = "10.0.1.0/24"
  tags = {
    "Name" = "subred-privada"
  }
}
