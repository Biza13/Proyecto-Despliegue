output "vpc_id" {
  value = aws_vpc.Desarrollo-web-VPC
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

output "instance_public_ip" {
  description = "IP publica de instancia EC2"
  value = aws_instance.instancia.public_ip
}