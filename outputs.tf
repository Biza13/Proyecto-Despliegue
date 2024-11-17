output "vpc_id" {
  value = aws_vpc.Desarrollo-web-VPC.id
  description = "El ID de la VPC"
}

output "subred_publica_id" {
  value = aws_subnet.subred-publica.id
  description = "ID de la subred pública"
}

output "subred_privada_id" {
  value = aws_subnet.subred-privada.id
  description = "ID de la subred privada"
}

#outputs que son salidas en consola cuando se hace el apply
/* output "instance-id" {
  description = "ID de instancia EC2"
  value = aws_instance.instancia
} */

#ip publica de instancia con ubuntu
output "instance_public_ip" {
  description = "IP publica de instancia EC2"
  value = aws_instance.instancia.public_ip
}

#ip publica de instancia con amazon linux
output "instance_public_ip" {
  description = "IP publica de instancia EC2 nginx"
  value = aws_instance.instancia-nginx.public_ip
}

output "s3" {
  value = aws_s3_bucket.s3.id
}

output "website_url" {
  value = "http://${aws_s3_bucket.s3.bucket}.s3-website-${var.region}.amazonaws.com"
}
