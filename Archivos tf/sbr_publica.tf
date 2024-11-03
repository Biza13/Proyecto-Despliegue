#creacion de la internet gateway
resource "aws_internet_gateway" "igw" {
  vpc_id = aws_vpc.Desarrollo-web-VPC.id
  tags = {
    Name = "internet_gateway"
  }
}

#creacion de l a tabla de enrutamiento
resource "aws_route_table" "public-rt" {
  vpc_id = aws_vpc.Desarrollo-web-VPC.id

  route {   //definir la ruta
    cidr_block = "0.0.0.0/0"   //permitir el trafico desde cualquier direccion ip hacia fuera de la vpc
    gateway_id = aws_internet_gateway.igw.id
  }

  tags = {
    Name = "Tabla Enrutamiento para Internet gateway"
  }
}

#asociar la tabla de enrutamiento a la subred publica
resource "aws_route_table_association" "rt-asociacion-publica" {
  subnet_id = aws_subnet.subred-publica.id
  route_table_id = aws_route_table.public-rt.id
}