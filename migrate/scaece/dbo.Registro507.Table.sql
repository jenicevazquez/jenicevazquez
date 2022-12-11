/****** Object:  Table [dbo].[Registro507]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro507](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[ClaveCaso] [varchar](50) NULL,
	[IdentificadorCaso] [varchar](50) NULL,
	[TipoPedimento] [varchar](50) NULL,
	[ComplementoCaso] [varchar](50) NULL,
	[FechaValidacionPagoR] [varchar](50) NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
