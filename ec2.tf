#Zona de viabilidad
/* resource "aws_ec2_availability_zone_group" "zona" {
  group_name    = "us-east-1"
  opt_in_status = "opted-in"
} */

#obtencion de datos es como que recorre on objeto y le estas diciendo que te de el objeto en el que coincidan los datos
#por ejemplo el nombre que sea lo que hay en el value. un if (name == values)
#esto permite crear, actualizar y borrar instancias
data "aws_ami" "ubuntu" {
  most_recent = true

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-jammy-22.04-amd64-server-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["099720109477"] # Canonical

}

#crear un grupo de seguridad para ssh y http/https
resource "aws_security_group" "security" {
  name = "seguridad"
  description = "Security group para permitir SSH y HTTP/HTTPS"
  vpc_id      = aws_vpc.Desarrollo-web-VPC.id  # Asegúrate de que esto apunte a la VPC correcta

  # ingres reglas de entrada
  ingress {
    from_port = 22
    to_port = 22
    protocol="tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port = 80
    to_port = 80
    protocol = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  
  #egress reglas de salida
  egress {
    from_port = 0
    to_port = 0
    protocol = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

# Definir el par de claves en Terraform
#solo una vez para obtener el par de claves despues reutilizamos las que tenemos
#resource "aws_key_pair" "deployer" {
#  key_name   = "deployer-key"
#  #public_key = file("C:/Users/serra/.ssh/deployer-key.pub")
#  #lo hacemos con la variable creada
#  public_key = var.public_key
#} 

#crear una instancia
resource "aws_instance" "instancia" {
  ami           = data.aws_ami.ubuntu.id
  instance_type = "t2.micro"    #poner el t2
  subnet_id = aws_subnet.subred-publica.id
  vpc_security_group_ids = [aws_security_group.security.id]
  #key_name      = aws_key_pair.deployer.key_name  # Usar la clave "deployer-key"
  key_name = "deployer-key"  # coje el par de claves que ya estan en aws por el nombre

  tags = {
    Name = "instancia"
  }

  user_data = <<-EOF
              #!/bin/bash
              # Datos de usuario
              apt update -y
              apt install -y apache2
              systemctl start apache2
              systemctl enable apache2
              echo "<h1>Hola mundo desde $(hostname -f)</h1>" > /var/www/html/index.html
              EOF
}