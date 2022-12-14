/****** Object:  Table [dbo].[RegistroSel]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[RegistroSel](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](50) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[ConsecutivoRemesa] [varchar](50) NULL,
	[NumeroSeleccion] [varchar](50) NULL,
	[FechaSeleccion] [date] NULL,
	[HoraSeleccion] [time](7) NULL,
	[SemaforoFiscal] [varchar](1) NULL,
	[ClaveDocumento] [varchar](3) NULL,
	[TipoOperacion] [varchar](1) NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
