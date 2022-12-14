/****** Object:  Table [dbo].[Registro508]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro508](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[InstitucionEmisora] [varchar](2) NULL,
	[NumeroCuenta] [varchar](50) NULL,
	[FolioConstancia] [varchar](17) NULL,
	[FechaConstancia] [date] NULL,
	[TipoCuenta] [varchar](2) NULL,
	[ClaveGarantia] [varchar](50) NULL,
	[ValorUnitarioTitulo] [decimal](18, 4) NULL,
	[TotalGarantia] [decimal](16, 2) NULL,
	[CantidadUnidades] [decimal](16, 2) NULL,
	[TitulosAsignados] [decimal](16, 2) NULL,
	[FechaPagoReal] [date] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
