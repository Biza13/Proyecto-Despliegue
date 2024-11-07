#Crear un ip elastica para la NAT gateway
resource "aws_eip" "NAt-gateway" {
  depends_on = [ aws_route_table_association.rt-asociacion-publica ]
  domain = "vpc"
}

resource "aws_nat_gateway" "nat-gateway" {
  allocation_id = aws_eip.NAt-gateway.id
  subnet_id     = aws_subnet.subred-publica.id  //se pone la subred publica para que tenga acceso hacia afuera

  tags = {
    Name = "NAT gateway"
  }
  depends_on = [aws_internet_gateway.igw]
}

#creamos la tabla de rutas para la nat gateway
resource "aws_route_table" "nat-gateway-rt" {
    //depends_on = [ aws_nat_gateway.nat-gateway ]
  vpc_id = aws_vpc.Desarrollo-web-VPC.id

  route {
    cidr_block = "0.0.0.0/0"    //permitir el trafico desde cualquier direccion hacia afuera de la vpc
    nat_gateway_id = aws_nat_gateway.nat-gateway.id
  }

  tags = {
    Name = "Tabla Enrutamiento para el NAT gateway"
  }
}

#asociar la tabla de enrutamiento con el nat gateway
resource "aws_route_table_association" "rt-asociacion-NAT" {
    //depends_on = [ aws_route_table.nat-gateway-rt ]
  subnet_id = aws_subnet.subred-privada.id
  route_table_id = aws_route_table.nat-gateway-rt.id
}