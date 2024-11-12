variable "public_key" {
  description = "Public key"
  type        = string
  default = ""
}

variable "s3"{
  description = "Nombre del bucket s3"
  type = string
}

variable "region"{
  description = "Region de creacion"
  type = string
}
