/****** Object:  Table [dbo].[detalleImportacion]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[detalleImportacion](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[unidadMedida] [varchar](5) NULL,
	[fraccion] [varchar](10) NULL,
	[tasa] [decimal](18, 2) NULL,
	[arancel] [decimal](18, 2) NULL,
	[moneda] [varchar](5) NULL,
	[determinacion_id] [int] NULL,
	[cantidadMedida] [decimal](18, 6) NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_detalleImportacion] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
